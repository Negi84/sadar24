<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessSetting;
use App\RefundRequest;
use App\Order;
use App\OrderDetail;
use App\Seller;
use App\Shop;
use App\Wallet;
use App\User;
use Auth;

class RefundRequestController extends Controller
{
	
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	 
	public $delhiveryEndpoint = '';
    public function __construct(){
        if (env('DELHIVERY_ENV') == 'Test') {
            $this->delhiveryEndpoint = env('DELHIVERY_TEST_ENDPOINT');
        }
        if (env('DELHIVERY_ENV') == 'Production') {
            $this->delhiveryEndpoint = env('DELHIVERY_PROD_ENDPOINT');
        }
    }  
	 
	
    //Store Customer Refund Request
    public function request_store(Request $request, $id)
    {
        $order_detail = OrderDetail::where('id', $id)->first();
        $refund = new RefundRequest;
        $refund->user_id = Auth::user()->id;
        $refund->order_id = $order_detail->order_id;
        $refund->order_detail_id = $order_detail->id;
        $refund->seller_id = $order_detail->seller_id;
        $refund->seller_approval = 0;
        $refund->reason = $request->reason;
        $refund->photos = $request->photos;
        $refund->admin_approval = 0;
        $refund->admin_seen = 0;
        $refund->refund_amount = $order_detail->price + $order_detail->tax;
        $refund->refund_status = 0;
        if ($refund->save()) {
            flash( translate("Refund Request has been sent successfully") )->success();
            return redirect()->route('purchase_history.index');
        }
        else {
            flash( translate("Something went wrong") )->error();
            return back();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendor_index()
    {
        $refunds = RefundRequest::where('seller_id', Auth::user()->id)->latest()->paginate(10);
        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return view('refund_request.frontend.recieved_refund_request.index', compact('refunds'));
        }
        else {
            return view('refund_request.frontend.recieved_refund_request.index', compact('refunds'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer_index()
    {
        $refunds = RefundRequest::where('user_id', Auth::user()->id)->latest()->paginate(10);
        return view('refund_request.frontend.refund_request.index', compact('refunds'));
    }

    //Set the Refund configuration
    public function refund_config()
    {
        return view('refund_request.config');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refund_time_update(Request $request)
    {
        $business_settings = BusinessSetting::where('type', $request->type)->first();
        if ($business_settings != null) {
            $business_settings->value = $request->value;
            $business_settings->save();
        }
        else {
            $business_settings = new BusinessSetting;
            $business_settings->type = $request->type;
            $business_settings->value = $request->value;
            $business_settings->save();
        }
        flash( translate("Refund Request sending time has been updated successfully") )->success();
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refund_sticker_update(Request $request)
    {
        $business_settings = BusinessSetting::where('type', $request->type)->first();
        if ($business_settings != null) {
            $business_settings->value = $request->logo;
            $business_settings->save();
        }
        else {
            $business_settings = new BusinessSetting;
            $business_settings->type = $request->type;
            $business_settings->value = $request->logo;
            $business_settings->save();
        }
        flash( translate("Refund Sticker has been updated successfully"))->success();
        return back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_index()
    {
        $refunds = RefundRequest::where('refund_status', 0)->latest()->paginate(15);
        return view('refund_request.index', compact('refunds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paid_index()
    {
        $refunds = RefundRequest::where('refund_status', 1)->latest()->paginate(15);
        return view('refund_request.paid_refund', compact('refunds'));
    }

    public function rejected_index()
    {
        $refunds = RefundRequest::where('refund_status', 2)->latest()->paginate(15);
        return view('refund_request.rejected_refund', compact('refunds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function request_approval_vendor(Request $request)
    {
        // dd($request);
        $refund = RefundRequest::findOrFail($request->el);
        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            $refund->seller_approval = 1;
            $refund->admin_approval = 1;
        }
        else {
            $refund->seller_approval = 1;
        }

        if ($refund->save()) {
            return 1;
        }
        else {
            return 0;
        }
    }

	public function refund_pay(Request $request)
    {
        $refund = RefundRequest::findOrFail($request->el);
        if ($refund->seller_approval == 1 || $refund->seller_approval == 0) {
			
			$return_data = $this->returnOrder($refund->order_id);			
			
			//echo "<pre>";print_r($return_data);die;
			
			$pcdata = $return_data['packages'];
			if($pcdata !=NULL){
				foreach($pcdata as $datas){						
					if($datas['status'] == 'Success'){							
						$seller = Seller::where('user_id', $refund->seller_id)->first();
						if ($seller != null) {
							$seller->admin_to_pay -= $refund->refund_amount;
						}
						$seller->save();
						
						$wallet = new Wallet;
						$wallet->user_id = $refund->user_id;
						$wallet->amount = $refund->refund_amount;
						$wallet->payment_method = 'Refund';
						$wallet->payment_details = 'Product Money Refund';
						$wallet->save();
						$user = User::findOrFail($refund->user_id);
						$user->balance += $refund->refund_amount;
						$user->save();
						if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
							$refund->admin_approval = 1;
							$refund->refund_status = 1;
							$refund->waybill = $datas['waybill'];
						}
						if ($refund->save()) {
							return 1;
						}
						else {
							return 0;
						}
					}else{
						if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
							$refund->admin_approval = 1;
							$refund->refund_status = 1;
							$refund->waybill = $datas['waybill'];
						}
						if ($refund->save()) {
							return 0;
						}
					}			
				}
			}
        }       
    }
	
	
    public function reject_refund_request(Request $request){
      $refund = RefundRequest::findOrFail($request->refund_id);
      if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
          $refund->admin_approval = 2;
          $refund->refund_status  = 2;
          $refund->reject_reason  = $request->reject_reason;
      }
      else{
          $refund->seller_approval = 2;
          $refund->reject_reason  = $request->reject_reason;
      }
      
      if ($refund->save()) {
          flash(translate('Refund request rejected successfully.'))->success();
          return back();
      }
      else {
          return back();
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refund_request_send_page($id)
    {
        $order_detail = OrderDetail::findOrFail($id);
        if ($order_detail->product != null && $order_detail->product->refundable == 1) {
            return view('refund_request.frontend.refund_request.create', compact('order_detail'));
        }
        else {
            return back();
        }
    }

    /**
     * Show the form for view the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Shows the refund reason
    public function reason_view($id)
    {
        $refund = RefundRequest::findOrFail($id);
        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            if ($refund->orderDetail != null) {
                $refund->admin_seen = 1;
                $refund->save();
                return view('refund_request.reason', compact('refund'));
            }
        }
        else {
            return view('refund_request.frontend.refund_request.reason', compact('refund'));
        }
    }

    public function reject_reason_view($id)
    {
        $refund = RefundRequest::findOrFail($id);
        return $refund->reject_reason;
    }
	
	
	/* Return order */
	public function returnOrder($id){			
		$order = Order::findOrFail($id);			
		if ($order != null) {
			foreach ($order->orderDetails as $key => $orderDetail) {						
				$seller = Shop::where('user_id', $orderDetail->seller_id)->first();				
				$shipping_detail = json_decode($order->shipping_address,true);				
				$payment_mode = $order->payment_type == 'cash_on_delivery'?'COD':'Pre-paid';
				$total_amount = round($order->grand_total, 2);
								
				if ($seller) {					
					$data_pin = array(					
						'add'=> preg_replace('/[; & # % ]+/', ' ', trim($seller->address)),
						'city'=> preg_replace('/[; & # % ]+/', ' ', trim($seller->city)),
						'country'=>preg_replace('/[; & # % ]+/', ' ', trim('India')),
						'name'=> preg_replace('/[; & # % ]+/', ' ', trim($seller->name)),
						'phone'=> preg_replace('/[; & # % ]+/', ' ', trim($seller->phone)),
						'pin'=> preg_replace('/[; & # % ]+/', ' ', trim($seller->postal_code)),
					); 
					
					$data_ship = array(	
						"waybill"=> '',
						"name"=>  preg_replace('/[; & # % ]+/', ' ', trim($shipping_detail['name'])),
						"order"=>  preg_replace('/[; & # % ]+/', ' ', trim($order->code)),
						"products_desc"=>  preg_replace('/[; & # % ]+/', ' ', trim('')),
						"order_date"=>  preg_replace('/[; & # % ]+/', ' ', trim($orderDetail->created_at)),
						"payment_mode"=>  'Pickup',
						"total_amount"=> $total_amount,	
						"cod_amount"=> $total_amount,
						"add"=>  preg_replace('/[; & # % ]+/', ' ', trim($shipping_detail['address'])),
						"city"=>  preg_replace('/[; & # % ]+/', ' ', trim($shipping_detail['city'])),
						"state"=>  preg_replace('/[; & # % ]+/', ' ', trim($shipping_detail['state'])),
						"country"=> preg_replace('/[; & # % ]+/', ' ', trim("India")),
						"phone"=>  preg_replace('/[; & # % ]+/', ' ', trim($shipping_detail['phone'])),
						"pin"=>  preg_replace('/[; & # % ]+/', ' ', trim($shipping_detail['postal_code'])),
						"return_add"=> preg_replace('/[; & # % ]+/', ' ', trim($seller->address)),
						"return_city"=>  preg_replace('/[; & # % ]+/', ' ', trim($seller->city)),
						"return_country"=> preg_replace('/[; & # % ]+/', ' ', trim("India")),	
						"return_name"=>  preg_replace('/[; & # % ]+/', ' ', trim($seller->name)),
						"return_phone"=>  preg_replace('/[; & # % ]+/', ' ', trim($seller->phone)),
						"return_pin"=>  preg_replace('/[; & # % ]+/', ' ', trim($seller->postal_code)),
						"return_state"=>  preg_replace('/[; & # % ]+/', ' ', trim($seller->state)),							
						"supplier"=> '',
						"extra_parameters"=> '',
						"shipment_width"=> '',
						"shipment_height"=> '',
						"weight"=> '',					
						"quantity"=> $orderDetail->quantity,					
						"seller_inv"=>  preg_replace('/[; & # % ]+/', ' ', trim($order->code)),
						"seller_inv_date"=>  preg_replace('/[; & # % ]+/', ' ', trim($orderDetail->created_at)),
						"seller_name"=> preg_replace('/[; & # % ]+/', ' ', trim($seller->name)),
						"seller_add"=> preg_replace('/[; & # % ]+/', ' ', trim($seller->address)),
						"seller_cst"=> '',
						"seller_tin"=> '',
						"consignee_tin"=> '',
						"commodity_value"=> '',
						"tax_value"=> '',
						"sales_tax_form_ack_no"=>'',
						"category_of_goods"=> '',
						"seller_gst_tin"=> '',
						"client_gst_tin"=> '',
						"consignee_gst_tin"=> '',
						"invoice_reference"=> '',
						"hsn_code"=> '',
					);							
					
					$data_pin_json = json_encode($data_pin);
					$data_ship_js = json_encode($data_ship);									
					
					$json_data = 'format=json&data={
						"pickup_location": '.$data_pin_json.',
						"shipments": [
							'.$data_ship_js.'
						]
					}';
					return $this->delhivery_reverse_order($json_data);
				}
			}
		
		}
	}	


	public function delhivery_reverse_order($data){    
		$url = $this->delhiveryEndpoint.'api/cmu/create.json';
		$response = postCurl($url,$data);
		$response = json_decode($response, true);
		return $response;
	}
	
	

}
