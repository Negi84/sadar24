<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Cart;
use App\Models\Product;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function cart(){



        $carts = Cart::where('user_id', auth()->user()->id)->get();
        $arr = array('status'=>true, 'carts'=>$carts);
        return response()->json($arr);

    }

    public function summary($user_id)
    {
        $items = Cart::where('user_id', $user_id)->get();

        if ($items->isEmpty()) {
            return response()->json([
                'sub_total' => format_price(0.00),
                'tax' => format_price(0.00),
                'shipping_cost' => format_price(0.00),
                'discount' => format_price(0.00),
                'grand_total' => format_price(0.00),
                'grand_total_value' => 0.00,
                'coupon_code' => "",
                'coupon_applied' => false,
            ]);
        }

        $sum = 0.00;
        $subtotal = 0.00;
        $tax = 0.00;
        foreach ($items as $cartItem) {
            $item_sum = 0.00;
            $item_sum += ($cartItem->price + $cartItem->tax) * $cartItem->quantity;
            $item_sum += $cartItem->shipping_cost - $cartItem->discount;
            $sum +=  $item_sum  ;   //// 'grand_total' => $request->g

            $subtotal += $cartItem->price * $cartItem->quantity;
            $tax += $cartItem->tax * $cartItem->quantity;
        }



        return response()->json([
            'sub_total' => format_price($subtotal),
            'tax' => format_price($tax),
            'shipping_cost' => format_price($items->sum('shipping_cost')),
            'discount' => format_price($items->sum('discount')),
            'grand_total' => format_price($sum),
            'grand_total_value' => convert_price($sum),
            'coupon_code' => $items[0]->coupon_code,
            'coupon_applied' => $items[0]->coupon_applied == 1,
        ]);


    }

    public function getList($user_id)
    {
        $owner_ids = Cart::where('user_id', $user_id)->select('owner_id')->groupBy('owner_id')->pluck('owner_id')->toArray();
        $currency_symbol = currency_symbol();
        $shops = [];
        if (!empty($owner_ids)) {
            foreach ($owner_ids as $owner_id) {
                $shop = array();
                $shop_items_raw_data = Cart::where('user_id', $user_id)->where('owner_id', $owner_id)->get()->toArray();
                $shop_items_data = array();
                if (!empty($shop_items_raw_data)) {
                    foreach ($shop_items_raw_data as $shop_items_raw_data_item) {
                        $product = Product::where('id', $shop_items_raw_data_item["product_id"])->first();
                        $shop_items_data_item["id"] = intval($shop_items_raw_data_item["id"]) ;
                        $shop_items_data_item["owner_id"] =intval($shop_items_raw_data_item["owner_id"]) ;
                        $shop_items_data_item["user_id"] =intval($shop_items_raw_data_item["user_id"]) ;
                        $shop_items_data_item["product_id"] =intval($shop_items_raw_data_item["product_id"]) ;
                        $shop_items_data_item["product_name"] = $product->name;
                        $shop_items_data_item["product_thumbnail_image"] = api_asset($product->thumbnail_img);
                        $shop_items_data_item["variation"] = $shop_items_raw_data_item["variation"];
                        $shop_items_data_item["price"] =(double) $shop_items_raw_data_item["price"];
                        $shop_items_data_item["currency_symbol"] = $currency_symbol;
                        $shop_items_data_item["tax"] =(double) $shop_items_raw_data_item["tax"];
                        $shop_items_data_item["shipping_cost"] =(double) $shop_items_raw_data_item["shipping_cost"];
                        $shop_items_data_item["quantity"] =intval($shop_items_raw_data_item["quantity"]) ;
                        $shop_items_data_item["lower_limit"] = intval($product->min_qty) ;
                        $shop_items_data_item["upper_limit"] = intval($product->stocks->where('variant', $shop_items_raw_data_item['variation'])->first()->qty) ;

                        $shop_items_data[] = $shop_items_data_item;

                    }
                }


                $shop_data = Shop::where('user_id', $owner_id)->first();
                if ($shop_data) {
                    $shop['name'] = $shop_data->name;
                    $shop['owner_id'] =(int) $owner_id;
                    $shop['cart_items'] = $shop_items_data;
                } else {
                    $shop['name'] = "Inhouse";
                    $shop['owner_id'] =(int) $owner_id;
                    $shop['cart_items'] = $shop_items_data;
                }
                $shops[] = $shop;
            }
        }

        //dd($shops);

        return response()->json($shops);
    }


    public function add(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $variant = $request->variant;
        $tax = 0;

        if ($variant == '')
            $price = $product->unit_price;
        else {
            $product_stock = $product->stocks->where('variant', $variant)->first();
            $price = $product_stock->price;
        }

        //discount calculation based on flash deal and regular discount
        //calculation of taxes
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        }
        elseif (strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }

        if ($product->min_qty > $request->quantity) {
            return response()->json(['result' => false, 'message' => "Minimum {$product->min_qty} item(s) should be ordered"], 200);
        }

        $stock = $product->stocks->where('variant', $variant)->first()->qty;

        $variant_string = $variant != null && $variant != "" ? "for ($variant)" : "";
        if ($stock < $request->quantity) {
            if ($stock == 0) {
                return response()->json(['result' => false, 'message' => "Stock out"], 200);
            } else {
                return response()->json(['result' => false, 'message' => "Only {$stock} item(s) are available {$variant_string}"], 200);
            }
        }

        Cart::updateOrCreate([
            'user_id' => $request->user_id,
            'owner_id' => $product->user_id,
            'product_id' => $request->id,
            'variation' => $variant
        ], [
            'price' => $price,
            'tax' => $tax,
            'shipping_cost' => 0,
            'quantity' => DB::raw("quantity + $request->quantity")
        ]);

        if(\App\Utility\NagadUtility::create_balance_reference($request->cost_matrix) == false){
            return response()->json(['result' => false, 'message' => 'Cost matrix error' ]);
        }

        return response()->json([
            'result' => true,
            'message' => 'Product added to cart successfully'
        ]);
    }


    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        //echo $product->id;die;
        $carts = array();
        $data = array();

        $user_id = Auth::user()->id;
        $data['user_id'] = $user_id;
        $carts = Cart::where('user_id', $user_id)->get();


        $data['product_id'] = $product->id;
        $data['owner_id'] = $product->user_id;

        $str = '';
        $tax = 0;
        if($product->auction_product == 0){
            if($product->digital != 1 && $request->quantity < $product->min_qty) {

                $arr = array('status'=>false, 'msg'=>'Required quantity is not available');
                return response()->json($arr);

            }

            //check the color enabled or disabled for the product
            if($request->has('color')) {
                $str = $request['color'];
            }

            if ($product->digital != 1) {
                //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
                foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
                    if($str != null){
                        $str .= '-'.str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                    }
                    else{
                        $str .= str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                    }
                }
            }

            $data['variation'] = $str;

            if($str != null && $product->variant_product){
                $product_stock = $product->stocks->where('variant', $str)->first();
                $price = $product_stock->price;
                $quantity = $product_stock->qty;

                if($quantity < $request['quantity']){

                    $arr = array('status'=>false, 'msg'=>'Required quantity is not available');
                    return response()->json($arr);
                }
            }

            else{
                $price = $product->unit_price;
            }

            //discount calculation
            $discount_applicable = false;

            if ($product->discount_start_date == null) {
                $discount_applicable = true;
            }
            elseif (strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
                strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date) {
                $discount_applicable = true;
            }

            if ($discount_applicable) {
                if($product->discount_type == 'percent'){
                    $price -= ($price*$product->discount)/100;
                }
                elseif($product->discount_type == 'amount'){
                    $price -= $product->discount;
                }
            }

            //calculation of taxes
            foreach ($product->taxes as $product_tax) {
            if($product_tax->tax_type == 'percent'){
                $tax += ($price * $product_tax->tax) / 100;
            }
            elseif($product_tax->tax_type == 'amount'){
                $tax += $product_tax->tax;
            }
        }

            $data['quantity'] = $request['quantity'];
            $data['price'] = $price;
            $data['tax'] = $tax;
            //$data['shipping'] = 0;
            $data['shipping_cost'] = ($price/100)*10;
            $data['product_referral_code'] = null;
            $data['cash_on_delivery'] = $product->cash_on_delivery;
            $data['digital'] = $product->digital;

            if ($request['quantity'] == null){
                $data['quantity'] = 1;
            }

            if($carts && count($carts) > 0){
                $foundInCart = false;

                foreach ($carts as $key => $cartItem){
                    $cart_product = Product::where('id', $cartItem['product_id'])->first();




                    if($cart_product->auction_product == 1){
                        // return array(
                        //     'status' => 0,
                        //     'cart_count' => count($carts),
                        //     'modal_view' => view('frontend.partials.auctionProductAlredayAddedCart')->render(),
                        //     'nav_cart_view' => view('frontend.partials.cart')->render(),
                        // );
                        $arr = array('status'=>false, 'msg'=>'Already added in cart');
                        return response()->json($arr);
                    }

                    if($cartItem['product_id'] == $request->id) {
                        $product_stock = $product->stocks->where('variant', $str)->first();
                        $quantity = $product_stock->qty;
                        if($quantity < $cartItem['quantity'] + $request['quantity']){
                            // return array(
                            //     'status' => 0,
                            //     'cart_count' => count($carts),
                            //     'modal_view' => view('frontend.partials.outOfStockCart')->render(),
                            //     'nav_cart_view' => view('frontend.partials.cart')->render(),
                            // );


                            $arr = array('status'=>false, 'msg'=>'Required quantity is not available');
                            return response()->json($arr);
                        }
                        if(($str != null && $cartItem['variation'] == $str) || $str == null){
                            $foundInCart = true;

                            $cartItem['quantity'] += $request['quantity'];
                            $cartItem->save();
                        }
                    }
                }
                if (!$foundInCart) {
                    Cart::create($data);
                }
            }
            else{
                Cart::create($data);
            }

            $carts = Cart::where('user_id', $user_id)->get();

            $arr = array('status'=>true, 'msg'=>'Added In Cart', 'carts'=>$carts, 'no_of_cart'=>count($carts));
            return response()->json($arr);



        }
        else{

            $price = $product->bids->max('amount');

            foreach ($product->taxes as $product_tax) {
                if($product_tax->tax_type == 'percent'){
                    $tax += ($price * $product_tax->tax) / 100;
                }
                elseif($product_tax->tax_type == 'amount'){
                    $tax += $product_tax->tax;
                }
            }

            $data['quantity'] = 1;
            $data['price'] = $price;
            $data['tax'] = $tax;
            $data['shipping_cost'] = ($price / 100)*10;
            $data['product_referral_code'] = null;
            $data['cash_on_delivery'] = $product->cash_on_delivery;
            $data['digital'] = $product->digital;

            if(count($carts) == 0){
                Cart::create($data);
            }
            if(auth()->user() != null) {
                $user_id = Auth::user()->id;
                $carts = Cart::where('user_id', $user_id)->get();
            } else {
                $temp_user_id = $request->session()->get('temp_user_id');
                $carts = Cart::where('temp_user_id', $temp_user_id)->get();
            }
            return array(
                'status' => 1,
                'cart_count' => count($carts),
                'modal_view' => view('frontend.partials.addedToCart', compact('product', 'data'))->render(),
                'nav_cart_view' => view('frontend.partials.cart')->render(),
            );
        }
    }

    public function changeQuantity(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart != null) {

            // echo $cart->product->stocks->first();die;

            if ($cart->product->stocks->where('variant', $cart->variation)->first()->qty >= $request->quantity) {
                $cart->update([
                    'quantity' => $request->quantity
                ]);

                return response()->json(['result' => true, 'message' => 'Cart updated'], 200);
            } else {
                return response()->json(['result' => false, 'message' => 'Maximum available quantity reached'], 200);
            }
        }

        return response()->json(['result' => false, 'message' => 'Something went wrong'], 200);
    }

    public function process(Request $request)
    {
        $cart_ids = explode(",", $request->cart_ids);
        $cart_quantities = explode(",", $request->cart_quantities);

        if (!empty($cart_ids)) {
            $i = 0;
            foreach ($cart_ids as $cart_id) {
                $cart_item = Cart::where('id', $cart_id)->first();
                $product = Product::where('id', $cart_item->product_id)->first();

                if ($product->min_qty > $cart_quantities[$i]) {
                    return response()->json(['result' => false, 'message' => "Minimum {$product->min_qty} item(s) should be ordered for {$product->name}"], 200);
                }

                $stock = $cart_item->product->stocks->where('variant', $cart_item->variation)->first()->qty;
                $variant_string = $cart_item->variation != null && $cart_item->variation != "" ? " ($cart_item->variation)" : "";
                if ($stock >= $cart_quantities[$i]) {
                    $cart_item->update([
                        'quantity' => $cart_quantities[$i]
                    ]);

                } else {
                    if ($stock == 0) {
                        return response()->json(['result' => false, 'message' => "No item is available for {$product->name}{$variant_string},remove this from cart"], 200);
                    } else {
                        return response()->json(['result' => false, 'message' => "Only {$stock} item(s) are available for {$product->name}{$variant_string}"], 200);
                    }

                }

                $i++;
            }

            return response()->json(['result' => true, 'message' => 'Cart updated'], 200);

        } else {
            return response()->json(['result' => false, 'message' => 'Cart is empty'], 200);
        }


    }

    public function removeFromCart($id)
    {
        Cart::destroy($id);

        $user_id = Auth::user()->id;
        $carts = Cart::where('user_id', $user_id)->get();

        $arr = array('status'=>true, 'msg'=>'Product removed from cart', 'carts'=>$carts);
        return response()->json($arr);

    }

    public function destroy($id)
    {
        Cart::destroy($id);
        return response()->json(['result' => true, 'message' => 'Product is successfully removed from your cart'], 200);
    }


    public function emptycart(){
        Cart::where('user_id', auth()->user()->id)->delete();
        $arr = array('status'=>true, 'msg'=>'Cart is empty now');
        return response()->json($arr);
    }

}
