<?php


namespace App\Http\Controllers\Api\V2;

use Auth;
use App\User;
use App\Coupon;
use App\Address;
use App\CouponUsage;
use App\Models\Cart;
use App\Models\Order;
use Razorpay\Api\Api;
use App\CombinedOrder;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Utility\NotificationUtility;
use App\Http\Resources\V2\AddressCollection;

class CheckoutController extends Controller
{
    public function apply_coupon_code(Request $request)
    {
        $cart_items = Cart::where('user_id', $request->user_id)->get();
        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if ($cart_items->isEmpty()) {
            return response()->json([
                'result' => false,
                'message' => 'Cart is empty'
            ]);
        }

        if ($coupon == null) {
            return response()->json([
                'result' => false,
                'message' => 'Invalid coupon code!'
            ]);
        }

        $in_range = strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date;

        if (!$in_range) {
            return response()->json([
                'result' => false,
                'message' => 'Coupon expired!'
            ]);
        }

        $is_used = CouponUsage::where('user_id', $request->user_id)->where('coupon_id', $coupon->id)->first() != null;

        if ($is_used) {
            return response()->json([
                'result' => false,
                'message' => 'You already used this coupon!'
            ]);
        }


        $coupon_details = json_decode($coupon->details);

        if ($coupon->type == 'cart_base') {
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            foreach ($cart_items as $key => $cartItem) {
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $shipping += $cartItem['shipping'] * $cartItem['quantity'];
            }
            $sum = $subtotal + $tax + $shipping;

            if ($sum >= $coupon_details->min_buy) {
                if ($coupon->discount_type == 'percent') {
                    $coupon_discount = ($sum * $coupon->discount) / 100;
                    if ($coupon_discount > $coupon_details->max_discount) {
                        $coupon_discount = $coupon_details->max_discount;
                    }
                } elseif ($coupon->discount_type == 'amount') {
                    $coupon_discount = $coupon->discount;
                }

                Cart::where('user_id', $request->user_id)->update([
                    'discount' => $coupon_discount / count($cart_items),
                    'coupon_code' => $request->coupon_code,
                    'coupon_applied' => 1
                ]);

                return response()->json([
                    'result' => true,
                    'message' => 'Coupon Applied'
                ]);


            }
        } elseif ($coupon->type == 'product_base') {
            $coupon_discount = 0;
            foreach ($cart_items as $key => $cartItem) {
                foreach ($coupon_details as $key => $coupon_detail) {
                    if ($coupon_detail->product_id == $cartItem['product_id']) {
                        if ($coupon->discount_type == 'percent') {
                            $coupon_discount += $cartItem['price'] * $coupon->discount / 100;
                        } elseif ($coupon->discount_type == 'amount') {
                            $coupon_discount += $coupon->discount;
                        }
                    }
                }
            }


            Cart::where('user_id', $request->user_id)->update([
                'discount' => $coupon_discount / count($cart_items),
                'coupon_code' => $request->coupon_code,
                'coupon_applied' => 1
            ]);

            return response()->json([
                'result' => true,
                'message' => 'Coupon Applied'
            ]);

        }


    }


    public function checkout(Request $request){
         //dd($cart->all());
         $total = 0;
         $total = 0;
         $tax = 0;
         $shipping = 0;
         $subtotal = 0;
         $discount = 0;
         $gst = array();

        $user_id = Auth::user()->id;

        $carts = Cart::where('user_id', $user_id)->get();
        //  dd($carts,count($carts));
        if(count($carts) == 0){
            $arr = array('status'=>false, 'msg'=>'Nothing in cart');
            return response()->json($arr);
        }

        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();


        if ($carts && count($carts) > 0) {
            foreach ($carts as $key => $cartItem) {
                $product = \App\Product::find($cartItem['product_id']);

                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $subtotal += ($cartItem['price'] * $cartItem['quantity']);
                $discount = round($discount + $cartItem['discount']);
                if ($request['shipping_type_' . $product->user_id] == 'pickup_point') {
                    $cartItem['shipping_type'] = 'pickup_point';
                    $cartItem['pickup_point'] = $request['pickup_point_id_' . $product->user_id];
                } else {
                    $cartItem['shipping_type'] = 'home_delivery';
                }
                $cartItem['shipping_cost'] = 0;
                if ($cartItem['shipping_type'] == 'home_delivery') {
                    $cartItem['shipping_cost'] = getShippingCost($carts, $key);
                }

                if(isset($cartItem['shipping_cost']) && is_array(json_decode($cartItem['shipping_cost'], true))) {

                    foreach(json_decode($cartItem['shipping_cost'], true) as $shipping_region => $val) {
                        if($shipping_info['city'] == $shipping_region) {
                            $cartItem['shipping_cost'] = (double)($val);
                            break;
                        } else {
                            $cartItem['shipping_cost'] = 0;
                        }
                    }
                } else {
                    if (!$cartItem['shipping_cost'] ||
                            $cartItem['shipping_cost'] == null ||
                            $cartItem['shipping_cost'] == 'null') {

                        $cartItem['shipping_cost'] = 0;
                    }
                }
                $tax += ($cartItem['shipping_cost'] * 0.0)* $cartItem['quantity'];
                //$shipping += $product_shipping_cost * $cartItem['quantity'];
                $shipping += $cartItem['shipping_cost'] * $cartItem['quantity'];
                $cartItem->save();

            }

            foreach ($carts as $key => $cartItem) {
                $product = \App\Product::find($cartItem['product_id']);
                $cartItem->slug = $product->slug;
            }

            $total = round($subtotal) + $tax + $shipping - $discount;
            $status = 1;
            // return view('frontend.payment_select', compact('carts', 'shipping_info', 'total'));
        }

        $arr = array('status'=>true, 'carts'=>$carts, 'sub_total'=>$subtotal,'Shipping'=>$shipping,'tax'=>$tax,'discount'=>$discount,'total'=>$total);
        return response()->json($arr);

    }

    public function order_place(Request $request){


        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $location_available = false;
        $lat = 90.99;
        $lang = 180.99;

        if ($carts->isEmpty()) {
            $arr = array('status'=>false, 'Cart is empty');
            return response()->json($arr);
        }
       // dd(Address::where('user_id', Auth::user()->id)->exists() == false);
        if(Address::where('user_id', Auth::user()->id)->exists() == false){
         $arr = array('status'=>false, 'msg'=>"The Delivery Address is not added!", 'combined_order_id'=>'');
         return response()->json($arr);
        }
        $shipping_info = Address::where('user_id', Auth::user()->id)->first();
        $shipping_info->name = Auth::user()->name;
        $shipping_info->email = Auth::user()->email;
        if(isset($shipping_info->latitude) || isset($shipping_info->longitude)) {
            $location_available = true;
            $lat = floatval($shipping_info->latitude) ;
            $lang = floatval($shipping_info->longitude);
        }
        $shipping_info->lat_lang = $lat . ',' . $lang;

        $combined_order = new CombinedOrder;
        $combined_order->user_id = Auth::user()->id;
        $combined_order->shipping_address = json_encode($shipping_info);
        $combined_order->save();

        $seller_products = array();
        foreach ($carts as $cartItem){
            $product_ids = array();
            $product = Product::find($cartItem['product_id']);
            if(isset($seller_products[$product->user_id])){
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $cartItem);
            $seller_products[$product->user_id] = $product_ids;
        }

        foreach ($seller_products as $seller_product) {
            $get_orderid = Order::orderBy('id', 'desc')->first();
			$last_orderid = 	$get_orderid ->id +1 ;

            $order = new Order;
            $order->combined_order_id = $combined_order->id;
            $order->user_id = Auth::user()->id;
            $order->shipping_address = json_encode($shipping_info);

            $order->payment_type = $request->payment_option;
            $order->delivery_viewed = '0';
            $order->payment_status_viewed = '0';
            $order->code = date('Ym') . $last_orderid;
            $order->date = strtotime('now');
            $order->device_type = 'Mobile';
            $order->save();

            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            $coupon_discount = 0;

            //Order Details Storing
            foreach ($seller_product as $cartItem) {
                $product = Product::find($cartItem['product_id']);

                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $coupon_discount += $cartItem['discount'];

                $product_variation = $cartItem['variation'];

                $product_stock = $product->stocks->where('variant', $product_variation)->first();
                // dd($product_stock);
                if ($product->digital != 1 && $cartItem['quantity'] > $product_stock->qty) {

                    $msg = translate('The requested quantity is not available for ') . $product->name;
                    $arr = array('status'=>false, 'msg'=>$msg);
                    $order->delete();
                    return response()->json($arr);

                } elseif ($product->digital != 1) {
                    $product_stock->qty -= $cartItem['quantity'];
                    $product_stock->save();
                }

                $order_detail = new OrderDetail;
                $order_detail->order_id = $order->id;
                $order_detail->seller_id = $product->user_id;
                $order_detail->product_id = $product->id;
                $order_detail->variation = $product_variation;
                $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                $order_detail->shipping_type = $cartItem['shipping_type'];
                $order_detail->product_referral_code = $cartItem['product_referral_code'];
                $order_detail->shipping_cost = $cartItem['shipping_cost'];

                $shipping += $order_detail->shipping_cost;

                if ($cartItem['shipping_type'] == 'pickup_point') {
                    $order_detail->pickup_point_id = $cartItem['pickup_point'];
                }
                //End of storing shipping cost

                $order_detail->quantity = $cartItem['quantity'];
                $order_detail->save();

                $product->num_of_sale += $cartItem['quantity'];
                $product->save();

                $order->seller_id = $product->user_id;

                if ($product->added_by == 'seller' && $product->user->seller != null){
                    $seller = $product->user->seller;
                    $seller->num_of_sale += $cartItem['quantity'];
                    $seller->save();
                }

                if (addon_is_activated('affiliate_system')) {
                    if ($order_detail->product_referral_code) {
                        $referred_by_user = User::where('referral_code', $order_detail->product_referral_code)->first();

                        $affiliateController = new AffiliateController;
                        $affiliateController->processAffiliateStats($referred_by_user->id, 0, $order_detail->quantity, 0, 0);
                    }
                }
            }

		 // $shiping_cost = $subtotal * 0.05;
			// $tax = $shiping_cost * 0.18;

            // $order->grand_total = $subtotal + $tax + $shiping_cost;
            $order->grand_total = $subtotal;

            if ($seller_product[0]->coupon_code != null) {
                // if (Session::has('club_point')) {
                //     $order->club_point = Session::get('club_point');
                // }
                $order->coupon_discount = $coupon_discount;
                $order->grand_total -= $coupon_discount;

                $coupon_usage = new CouponUsage;
                $coupon_usage->user_id = Auth::user()->id;
                $coupon_usage->coupon_id = Coupon::where('code', $seller_product[0]->coupon_code)->first()->id;
                $coupon_usage->save();
            }

            $combined_order->grand_total += $order->grand_total;

            $order->save();
        }

        $combined_order->save();

        $combined_order_id = $combined_order->id;
        $payment_type = 'cart_payment';

        $combined_order = CombinedOrder::findOrFail($combined_order_id);

        if ($combined_order_id != null) {


            if ($request->payment_option == 'razorpay') {

                foreach ($combined_order->orders as $key => $order) {
                    $order = Order::findOrFail($order->id);
                    $order->payment_status = 'failed';
                    $order->payment_details = $request->payment_details;
                    $order->delivery_status = 'cancelled';
                    $order->grand_total = $order->grand_total - 20;
                    $order->save();

                    foreach ($order->orderDetails as $key => $orderDetail) {
                        $orderDetail->payment_status = 'failed';
                        $orderDetail->delivery_status = 'cancelled';
                        $orderDetail->save();
                    }
                    //calculateCommissionAffilationClubPoint($order);
                }

                $combined_order->grand_total = $order->grand_total;
                $combined_order->save();

                $orderData = [
                    'receipt'         => $combined_order_id,
                    'amount'          => $combined_order->grand_total * 100, 
                    'currency'        => 'INR',
                    'payment_capture' => 1 // auto capture
                ];
                $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
                $razorpayOrder = $api->order->create($orderData);
                $razorpayOrderId = $razorpayOrder['id'];
                // dd(Auth::user()->id);
                
                $arr = array('status'=>true, 'msg'=>"Order Id generated", 'combined_order_id'=>$combined_order_id,'razorpayOrderId'=>$razorpayOrderId);
                return response()->json($arr);


            }elseif ($request->payment_option == 'cash_on_delivery') {
                foreach($combined_order->orders as $order){
                    // dump($order);
                    calculateCommissionAffilationClubPoint($order);
                    NotificationUtility::sendOrderPlacedNotification($order);
                }
              
                Cart::where('user_id', Auth::user()->id)->delete();
                $arr = array('status'=>true, 'msg'=>"Your order has been placed successfully", 'combined_order_id'=>$combined_order_id,'razorpayOrderId'=>"");
                return response()->json($arr);


            } elseif ($request->payment_option == 'wallet') {

                $user = Auth::user();
                if ($user->balance >= $combined_order->grand_total) {
                    $user->balance -= $combined_order->grand_total;
                    $user->save();
                    //return $this->checkout_done($request->session()->get('combined_order_id'), null);


                    foreach ($combined_order->orders as $key => $order) {
                        $order = Order::findOrFail($order->id);
                        $order->payment_status = 'paid';
                        $order->payment_details = null;
                        $order->delivery_status = 'pending';
                        $order->save();
                        calculateCommissionAffilationClubPoint($order);
                        NotificationUtility::sendOrderPlacedNotification($order);

                        foreach ($order->orderDetails as $key => $orderDetail) {
                            $orderDetail->payment_status = 'paid';
                            $orderDetail->delivery_status = 'pending';
                            $orderDetail->save();
                        }
                        //calculateCommissionAffilationClubPoint($order);
                    }
                    $arr = array('status'=>true, 'msg'=>'Order placed succesfully', 'combined_order_id'=> $combined_order_id,'razorpayOrderId'=>"");
                    return response()->json($arr);


                }

            } else {

                    $combined_order = CombinedOrder::findOrFail($request->session()->get('combined_order_id'));
                    $product_id = $combined_order->orderDetails->product->id;
                    $product = \App\Product::select('category_id')->where('id', $product_id)->first();
                    $category_id = $product->category_id;
                    $category = \App\Category::select('gst')->where('id', $category_id)->first();
                    $combined_order->gst = $category->gst;
                    foreach ($combined_order->orders as $order) {
                        $order->manual_payment = 1;
                        $order->save();
                        calculateCommissionAffilationClubPoint($order); 
                        NotificationUtility::sendOrderPlacedNotification($order);
                    }

                flash(translate('Your order has been placed successfully. Please submit payment information from purchase history'))->success();
                return redirect()->route('order_confirmed');
            }
        }



    }


    public function remove_coupon_code(Request $request)
    {
        Cart::where('user_id', $request->user_id)->update([
            'discount' => 0.00,
            'coupon_code' => "",
            'coupon_applied' => 0
        ]);

        return response()->json([
            'result' => true,
            'message' => 'Coupon Removed'
        ]);
    }
}