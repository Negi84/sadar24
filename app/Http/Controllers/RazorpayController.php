<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Redirect;
use App\CombinedOrder;
use App\Seller;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Input;
use App\CustomerPackage;
use App\SellerPackage;
use App\Http\Controllers\CustomerPackageController;
use Auth;
use App\Order;
use App\OrderDetail;

class RazorpayController extends Controller
{
    public function payWithRazorpay($request)
    {
        //dd($request);
        if(Session::has('payment_type')){
			if(Session::get('payment_type') == 'cart_payment'){
                $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));
               foreach ($combined_order->orders as $key => $order) {
					$order = Order::findOrFail($order->id);
					$order->payment_status = 'failed';
					$order->delivery_status = 'cancelled';
                    // $order->grand_total = $order->grand_total - 20;
					$order->save();
					foreach ($order->orderDetails as $key => $orderDetail) {
						$orderDetail->payment_status = 'failed';
						$orderDetail->delivery_status = 'cancelled';
						$orderDetail->save();
					}

				}
                // $combined_order->grand_total = $combined_order->grand_total + $order->grand_total;

                // $combined_order->save();
			//	dd($combined_order);
                return view('frontend.razor_wallet.order_payment_Razorpay', compact('combined_order'));
            }
            elseif (Session::get('payment_type') == 'wallet_payment') {
                return view('frontend.razor_wallet.wallet_payment_Razorpay');
            }
            elseif (Session::get('payment_type') == 'customer_package_payment') {
                return view('frontend.razor_wallet.customer_package_payment_Razorpay');
            }
            elseif (Session::get('payment_type') == 'seller_package_payment') {
                return view('frontend.razor_wallet.seller_package_payment_Razorpay');
            }
        }

    }

    public function payment(Request $request)
    {
        //dd($request);
        //Input items of form
        $input = $request->all();
        //get API Configuration
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
       // dd($input);
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            $payment_detalis = null;
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $payment_detalis = json_encode(array('id' => $response['id'],'method' => $response['method'],'amount' => $response['amount'],'currency' => $response['currency']));
            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }

            // Do something here for store payment details in database...
            if(Session::has('payment_type')){
                if(Session::get('payment_type') == 'cart_payment'){
                    $checkoutController = new CheckoutController;
                    return $checkoutController->checkout_done(Session::get('combined_order_id'), $payment_detalis);
                }
                elseif (Session::get('payment_type') == 'wallet_payment') {
                    $walletController = new WalletController;
                    return $walletController->wallet_payment_done(Session::get('payment_data'), $payment_detalis);
                }
                elseif (Session::get('payment_type') == 'customer_package_payment') {
                    $customer_package_controller = new CustomerPackageController;
                    return $customer_package_controller->purchase_payment_done(Session::get('payment_data'), $payment);
                }
                elseif (Session::get('payment_type') == 'seller_package_payment') {
                    $seller_package_controller = new SellerPackageController;
                    return $seller_package_controller->purchase_payment_done(Session::get('payment_data'), $payment);
                }
            }
        }
    }
}
