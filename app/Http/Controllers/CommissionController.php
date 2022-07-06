<?php

namespace App\Http\Controllers;

use App\CommissionHistory;
use Illuminate\Http\Request;
use App\SellerWithdrawRequest;
use App\Seller;
use App\Payment;
use App\Category;
use App\Coupon;
use App\CouponUsage;
use App\ProductTax;
use Session;

class CommissionController extends Controller
{
    //redirect to payment controllers according to selected payment gateway for seller payment
	
	public function pay_to_seller(Request $request)
    {
	
		$payment_id = $request->payment_id;
		$payment_date = $request->payment_date;
		$payment_option = $request->payment_method;
		
		foreach ($payment_id as $payment_detail) {	
			$commission_history = CommissionHistory::where('id', $payment_detail)->first();		
			
			$payment = new Payment;
			$payment->order_id = $commission_history->code;
            $payment->seller_id = $commission_history->seller_id;
            $payment->amount = $commission_history->seller_earning;                       
            $payment->payment_method = $payment_option;
			$payment->payment_details = 'Online Transfer';
			$payment->paid_date       = $payment_date;
            $payment->save();
			
			$commission_history->paid_amount = $commission_history->seller_earning; 
			$commission_history->paid_date   = $payment_date;
            $commission_history->save();
		}
		flash(translate('Payment completed'))->success();
		return redirect()->route('seller_account.index');		
	}

    //redirects to this method after successfull seller payment
    public function seller_payment_done($payment_data, $payment_details){
        $seller = Seller::findOrFail($payment_data['seller_id']);
        $seller->admin_to_pay = $seller->admin_to_pay - $payment_data['amount'];
        $seller->save();

        $payment = new Payment;
        $payment->seller_id = $seller->id;
        $payment->amount = $payment_data['amount'];
        $payment->payment_method = $payment_data['payment_method'];
        $payment->txn_code = $payment_data['txn_code'];
        $payment->payment_details = $payment_details;
        $payment->save();

        if ($payment_data['payment_withdraw'] == 'withdraw_request') {
            $seller_withdraw_request = SellerWithdrawRequest::findOrFail($payment_data['withdraw_request_id']);
            $seller_withdraw_request->status = '1';
            $seller_withdraw_request->viewed = '1';
            $seller_withdraw_request->save();
        }

        Session::forget('payment_data');
        Session::forget('payment_type');

        if ($payment_data['payment_withdraw'] == 'withdraw_request') {
            flash(translate('Payment completed'))->success();
            return redirect()->route('withdraw_requests_all');
        }
        else {
            flash(translate('Payment completed'))->success();
            return redirect()->route('sellers.index');
        }
    }

	public function calculateCommission($order){
		
		foreach ($order->orderDetails as $orderDetail ) {			
			
			//echo $order->user_id;die;	
			
			if(empty($orderDetail->product)){
				$check_user_type = 'seller';
			}else{
				$check_user_type = $orderDetail->product->user->user_type;
			}
			
			if($order->coupon_discount > 0){				
				if(count($order->orderDetails) > 1){
					$get_coupon = CouponUsage::where('user_id', $order->user_id)->where('created_at', $order->created_at)->first();				
					if (empty($get_coupon)) {				
						$discount_value = $order->coupon_discount;
					}else{
						$coupon_data = Coupon::where('id', $get_coupon->coupon_id)->first();
						if($coupon_data->discount_type == 'percent'){				
							$discount_value = ($orderDetail->price / 100) * $coupon_data->discount;
						}else if ($coupon_data->discount_type == 'amount'){
							$discount_value = $orderDetail->price - $coupon_data->discount;
						}
					}
				}else{
					$discount_value = $order->coupon_discount;
				}
			}else{
				$discount_value = 0;
			}
			
			if(get_setting('vendor_commission_activation') &&  $order->code >= '2022034533'){
				if (get_setting('category_wise_commission')) {
					$commission_percentage = $orderDetail->product->category->commision_rate;
				}else if ($check_user_type == 'seller') {
					$commission_percentage = get_setting('vendor_commission');
				}				
				$platform_charges = (($orderDetail->price * $commission_percentage)/100);
				$platform_charges_with_gst = $platform_charges * 18/100;
				
			}else{				
				$commission_amount = 50;
				$platform_charges = $commission_amount * $orderDetail->quantity;
				$platform_charges_with_gst = $platform_charges * 18/100;				
			}
			
			/* if(!empty($orderDetail->product->category_id)){
				$parent = Category::where('id', $orderDetail->product->category_id)->first();
				$gst = $parent->gst;				
			}else{
				$gst = 0;
			} */
			
			$check_product_gst = ProductTax::select('tax')->where('product_id', $orderDetail->product_id)->first();	
			if ($check_product_gst === null) {
				if(!empty($orderDetail->product->category)){
					$gst = $orderDetail->product->category->gst;			
				}else{
					$gst = 0;
				}	
			}else{
				$gst = $check_product_gst->tax;
			}
			
			$product_price = (($orderDetail->price /(100 + $gst))*100);		
			$gst_on_product_amount = $orderDetail->price - $product_price;
			$shipping_cost = $orderDetail->shipping_cost;
			$shipping_with_gst = (($shipping_cost * 18) / 100);			
			
			$grand_total = (($orderDetail->price + $shipping_cost + $shipping_with_gst) - $discount_value);
			$tds = ((($orderDetail->price /(100 + $gst))* 100) / 100);
			$tcs = ((($orderDetail->price /(100 + $gst))* 100) / 100);
			$admin_commission = $platform_charges + $platform_charges_with_gst + $shipping_cost + $shipping_with_gst + $tds + $tcs;				
			$seller_earning  = ($grand_total + $discount_value) - $admin_commission;
			
			$commission_history = new CommissionHistory;
			$commission_history->order_id 					= $order->id;
			$commission_history->order_detail_id 			= $orderDetail->id;
			$commission_history->code 						= $order->code;
			$commission_history->seller_id 					= $orderDetail->seller_id;			
			$commission_history->product_price 				= $product_price;
			$commission_history->gst_on_product 			= $gst;
			$commission_history->gst_on_product_amount 		= $gst_on_product_amount;
			$commission_history->subtotal  					= $orderDetail->price;
			$commission_history->coupon_discount 			= $discount_value;
			$commission_history->invoice_amount   			= $grand_total;
			$commission_history->amount_received  		    = $grand_total;
			$commission_history->delivery_status 			= $order->delivery_status;
			$commission_history->payment_status 			= $order->payment_status;
			$commission_history->platform_charges 			= $platform_charges;
			$commission_history->platform_charges_with_gst  = $platform_charges_with_gst;
			$commission_history->shipping 		   			= $shipping_cost;
			$commission_history->shipping_with_gst			= $shipping_with_gst;
			$commission_history->tds  						= $tds;
			$commission_history->tcs 						= $tcs;			
			$commission_history->admin_commission		    = $admin_commission;
			$commission_history->seller_earning             = $seller_earning;
			$commission_history->created_at 			    = $order->created_at;
			$commission_history->updated_at 			    = $order->updated_at;
			$commission_history->save(); 
		}
		
	}
	
	
	public function seller_account_commission_edit($id)
    {
        $commission = CommissionHistory::findOrFail($id);
        return view('backend.sellers.seller_account.edit', compact('commission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	 
    public function update(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        $user = $seller->user;       
		$user->name = $request->name;
        $user->email = $request->email;
		$user->phone = $request->phone;        	
		$user->address = $request->address;
		$user->country = $request->country;
		$user->state = $request->state;
		$user->city = $request->city;
		$user->postal_code = $request->postal_code;	   
        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        if ($user->save()) {
			
			$seller = $seller->user->seller;			
			$seller->bank_name = $request->bank_name;
			$seller->bank_acc_name = $request->bank_acc_name;
			$seller->bank_acc_no = $request->bank_acc_no;
			$seller->account_type = $request->account_type;
			$seller->ifsc_code = $request->ifsc_code;
			$seller->branch = $request->branch;
			
            if ($seller->save()) {
				$shop = $seller->user->shop;
				$shop->name = $request->company;
				$shop->types_of_business = $request->types_of_business;
				$shop->phone = $request->phone;
				$shop->address = $request->address;
				$shop->country = $request->country;
				$shop->state = $request->state;
				$shop->city = $request->city;
				$shop->postal_code = $request->postal_code;				
				$shop->gst_number = $request->gst_number;
				$shop->pan_number = $request->pan_number;				
				$shop->slug = Str::slug($request->company)."-". $user->id; 				
				$shop->save();				
                flash(translate('Seller has been updated successfully'))->success();
                return redirect()->route('sellers.index');
            }
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

}
