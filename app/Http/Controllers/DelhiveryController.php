<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\CommissionHistory;

class DelhiveryController extends Controller
{
    public function getWebhookResponse(Request $request)
    {
        //Log::info('Delhivery Webhook Request - ', $request->all());
        $data = $request->all();
        $waybill_no = trim($data["Shipment"]['AWB'] ?? '');

        if (!empty($waybill_no)) {
            $order = Order::where('waybill', $waybill_no)->first();

            if (!empty($order)) {
                $order_status = $this->updateOrderDeliveryStatus($order, $data);               
            }
        }
        //Log::error('Waybill no must not be empty');
        return 'Success';
    }


    /**
     * @param $order
     * @param $data
     * @return string
     */
    protected function updateOrderDeliveryStatus($order, $data): string
    {
        		
		$status = $data["Shipment"]["Status"]["Status"];
        $instructions = $data["Shipment"]["Status"]["Instructions"];
        $statusDateTime = $data["Shipment"]["Status"]["StatusDateTime"];
		
		if(($status == 'Manifested' && $instructions == 'Pickup scheduled') || ($status == 'In Transit' && $instructions == 'Shipment Received at Facility') || ($status == 'Dispatched' && $instructions == 'Out for delivery') || ($order->delivery_status == 'pending'))
		{				
			$order->delivery_status = $instructions;
			$order->delivery_viewed = '0';
			$order->updated_at = $statusDateTime;
			$order->save();
			
			foreach ($order->orderDetails as $key => $orderDetail) {
			
				$commission_history = CommissionHistory::firstWhere('order_detail_id', $orderDetail->id);
				
				$orderDetail->delivery_status = $instructions;
				$orderDetail->updated_at = $statusDateTime;
				$orderDetail->save();
				
				$commission_history->delivery_status = $instructions;
				$commission_history->delivered_date  = $statusDateTime;
				$commission_history->save();				
			}
			
			if($status == 'Manifested' && $instructions == 'Pickup scheduled'){			
				$whatsapp_event = "Shipment_Manifested";
				$this->sendWhatsappToClient($order,$whatsapp_event);
			}elseif($status == 'In Transit' && $instructions == 'Shipment Received at Facility'){
				$whatsapp_event = "Shipment_InTransit";
				$this->sendWhatsappToClient($order,$whatsapp_event);
			}elseif($status == 'Dispatched' && $instructions == 'Out for delivery'){
				$whatsapp_event = "Shipment_Dispatched";
				$this->sendWhatsappToClient($order,$whatsapp_event);
			}	
			
		}else if($status == 'Delivered'  && $instructions == 'Delivered to consignee' ){	
	
			$order->payment_status = 'paid';
			$order->delivery_status = 'delivered';
			$order->delivery_viewed = '0';
			$order->updated_at = $statusDateTime;
			$order->save();
			
			foreach ($order->orderDetails as $key => $orderDetail) {	
				
				$commission_history = CommissionHistory::firstWhere('order_detail_id', $orderDetail->id);
				
				$orderDetail->payment_status = 'paid';
				$orderDetail->delivery_status = 'delivered';
				$orderDetail->updated_at = $statusDateTime;
				$orderDetail->save();
				
				$commission_history->payment_status  = 'paid';
				$commission_history->delivery_status = 'delivered';
				$commission_history->delivered_date  = $statusDateTime;
				$commission_history->save();
				
			}
			if($status == 'Delivered' && $instructions == 'Delivered to consignee'){			
				$whatsapp_event = "Shipment_Delivered";
				$this->sendWhatsappToClient($order,$whatsapp_event);
			}
		}
		
		return $order->delivery_status;
    }
	
	/**
     * @param $status
     * @param $instructions
     */
	
	public static function sendWhatsappToClient($order,$whatsapp_event){    
		
		$shipping_detail = json_decode($order->shipping_address,true);		
		$phone_number = preg_replace('/\s+/', '', $shipping_detail['phone']);
		$phone_number_length  =   strlen($phone_number);		
		
		if($phone_number_length >10){
			$country_code = '+91';				
			$customer_phone = preg_replace("/^\+?{$country_code}/", '',$phone_number);
		}else{
			$customer_phone = $phone_number;
		}	
		
		$create_customer_data = array(
			'userId'=> 'SADWEB-'.$order->user->id,
			'phoneNumber'=> $customer_phone,
			'countryCode'=> "+91",
			'traits'=> array(
				'name'  => $shipping_detail['name'],
				'email' => $shipping_detail['email'],
			),
		); 
				
		$json_create_customer_data = json_encode($create_customer_data);			
		self::whatsapp_user_track($json_create_customer_data);
						
		$sendWhatsappToClient = array(
			'userId'=> 'SADWEB-'.$order->user->id,
			'phoneNumber'=> $customer_phone,
			'countryCode'=> "+91",
			"event" => $whatsapp_event,
			'traits'=> array(
				'Customer Name'	=> $shipping_detail['name'],
				'Order ID'		=> $order->code,
				'AWB'			=> $order->waybill,
			),
			'createdAt'=> $order->created_at,
		)
		; 
				
		$json_sendWhatsappToClient = json_encode($sendWhatsappToClient);	
		self::whatsapp_order_notification($json_sendWhatsappToClient);		
	}
	
	public static function whatsapp_user_track($data){    
		$url = env('WHATSAPP_ENDPOINT').'users/';
		$response = whatsappPostCurl($url,$data);
		$response = json_decode($response, true);
		return $response;
	}

	public static function whatsapp_order_notification($data){    
		$url = env('WHATSAPP_ENDPOINT').'events/';
		$response = whatsappPostCurl($url,$data);
		$response = json_decode($response, true);
		return $response;
	}
}
