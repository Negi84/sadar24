<?php


namespace App\Http\Controllers\Api\V2;


use App\User;
use App\Order;
use App\Models\Cart;
use Razorpay\Api\Api;
use App\CombinedOrder;
use Illuminate\Http\Request;
use App\Utility\NotificationUtility;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerPackageController;

class RazorpayController
{

    public function payWithRazorpay(Request $request)
    {
        $payment_type = $request->payment_type;
        $combined_order_id = $request->combined_order_id;
        $amount = $request->amount;
        $user_id = $request->user_id;
        $user = User::find($user_id);

        if ($payment_type == 'cart_payment') {
            $combined_order = CombinedOrder::find($combined_order_id);
            $shipping_address = json_decode($combined_order->shipping_address,true);
            return view('frontend.razorpay.order_payment', compact('user','combined_order', 'shipping_address'));
        } elseif ($payment_type == 'wallet_payment') {

            return view('frontend.razorpay.wallet_payment',  compact('user', 'amount'));
        }
    }


    public function payment(Request $request)
    {
        //Input items of form
        $input = $request->all();
        //get API Configuration
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));


        if (count($input) && !empty($input['razorpay_payment_id'])) {
            $payment_detalis = null;
            try {
                // $payment_details =[];
                //Fetch payment information by razorpay_payment_id
                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $payment_details = json_encode(array('id' => $response['id'], 'method' => $response['method'], 'amount' => $response['amount'], 'currency' => $response['currency']));
                $combined_order_id = $request->combined_order_id;    
                $combined_order = CombinedOrder::findOrFail($combined_order_id);
                foreach ($combined_order->orders as $key => $order) {
                    $order = Order::findOrFail($order->id);
                    $order->payment_status = 'paid';
                    $order->payment_details = $request->payment_details;
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
                Cart::where('user_id', Auth::user()->id)->delete();
                return response()->json(['result' => true, 'message' => "Payment Successful", 'payment_details' => $payment_details]);
            } catch (\Exception $e) {
                return response()->json(['result' => false, 'message' => $e->getMessage(), 'payment_details' => '']);
            }
        } else {
            $combined_order_id = $request->combined_order_id;    
            $combined_order = CombinedOrder::findOrFail($combined_order_id);
            foreach ($combined_order->orders as $key => $order) {
                $order = Order::findOrFail($order->id);
                $order->payment_status = 'failed';
                $order->payment_details = $request->payment_details;
                $order->delivery_status = 'cancelled';
                $order->save();
                calculateCommissionAffilationClubPoint($order);
                NotificationUtility::sendOrderPlacedNotification($order);


                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->payment_status = 'failed';
                    $orderDetail->delivery_status = 'cancelled';
                    $orderDetail->save();
                }
                //calculateCommissionAffilationClubPoint($order);
            }
            return response()->json(['result' => false, 'message' => 'Payment Failed', 'payment_details' => '']);
        }
    }

    public function success(Request $request)
    {
        try {

            $payment_type = $request->payment_type;

            if ($payment_type == 'cart_payment') {

                checkout_done($request->combined_order_id, $request->payment_details);
            }

            if ($payment_type == 'wallet_payment') {

                wallet_payment_done($request->user_id, $request->amount, 'Razorpay', $request->payment_details);
            }

            return response()->json(['result' => true, 'message' => "Payment is successful"]);


        } catch (\Exception $e) {
            return response()->json(['result' => false, 'message' => $e->getMessage()]);
        }
    }

}
