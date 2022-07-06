<?php

namespace App\Utility;

use App\Mail\InvoiceEmailManager;
use App\User;
use App\SmsTemplate;
use App\Http\Controllers\OTPVerificationController;
use Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderNotification;
use App\FirebaseNotification;
use Illuminate\Support\Facades\Log;

class NotificationUtility
{
    public static function sendOrderPlacedNotification($order, $request = null)
    {        
       /*  if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'order_placement')->first()->status == 1) {
            try {
                $otpController = new OTPVerificationController;
                $otpController->send_order_code($order);
            } catch (\Exception $e) {

            }
        }
		
		$seller = \App\Seller::where('user_id', $order->seller_id)->first();
		$seller_details = $seller->user->shop;
		$seller_email = $seller->user->email;

		//sends email to customer with the invoice pdf attached
         if (env('MAIL_USERNAME') != null) {
			// dump(env('MAIL_USERNAME'),env('MAIL_FROM_ADDRESS'));

			//admin mail details
            $array['view'] = 'emails.invoice';
            $array['subject'] = translate('Your order has been placed') . ' - ' . $order->code;
            $array['from'] = env('MAIL_FROM_ADDRESS');
            $array['order'] = $order;
			//user mail details
            $array2['view'] = 'emails.invoice';
            $array2['subject'] = translate('Your order has been placed') . ' - ' . $order->code;
            $array2['from'] = env('MAIL_FROM_ADDRESS');
            $array2['order'] = $order;
			//vendor mail details
			$array1['view'] = 'emails.sellerinvoice';
            $array1['subject'] = 'Received a New Order' . ' - ' . $order->code;
            $array1['from'] = env('MAIL_FROM_ADDRESS');
            $array1['order'] = $order;
			// dump($array,$array1,$array2,$order->user->email);
            try {
                Mail::to($order->user->email)->queue(new InvoiceEmailManager($array2));
				
                Mail::to("order-updates@sadar24.com")->queue(new InvoiceEmailManager($array));
                // Mail::to($order->user->email)->queue(new InvoiceEmailManager($array));
				
				Mail::to($seller_email)->queue(new InvoiceEmailManager($array1));
				// Mail::to($order->user->email)->queue(new InvoiceEmailManager($array1));
            } catch (\Exception $e) {
				// Log::info('Exception in mail is ', $e);
            }
        }
		
		
		$shipping_detail = json_decode($order->shipping_address,true);		
		$phone_number = preg_replace('/\s+/', '', $shipping_detail['phone']);
		$phone_number_length  =   strlen($phone_number);		
		
		if($phone_number_length >10){
			$country_code = '+91';				
			$customer_phone = preg_replace("/^\+?{$country_code}/", '',$phone_number);
		}else{
			$customer_phone = $phone_number;
		}	
		
		//send sms Customer
		$sendsmstocustomer = array(
			'From'=> 'SADRTF',
			'To' => $customer_phone,
			'TemplateName'=> "OrderPlaced",
			'VAR1' => $shipping_detail['name'],				
			'VAR2'=> $order->code,			
		); 
		
		$json_sendsmstocustomer = json_encode($sendsmstocustomer);		
		smsPostCurl($json_sendsmstocustomer);

		//send sms vendor		
		$sendsmstoseller = array(
			'From'=> 'SADRTF',
			'To' => $seller_details->phone,
			'TemplateName'=> "VendorNewOrder",
			'VAR1' => $seller_details->name,		
		); 
						
		$json_sendsmstoseller = json_encode($sendsmstoseller);
		smsPostCurl($json_sendsmstoseller);
		
		self::sendWhatsappToCustomer($order);
		self::sendWhatsappToSeller($order,$seller);
		 */
	}
	
	public static function sendWhatsappToCustomer($order){    
		
		$shipping_detail = json_decode($order->shipping_address,true);		
		$phone_number = preg_replace('/\s+/', '', $shipping_detail['phone']);
		$phone_number_length  =   strlen($phone_number);		
		
		if($phone_number_length >10){
			$country_code = '+91';				
			$customer_phone = preg_replace("/^\+?{$country_code}/", '',$phone_number);
		}else{
			$customer_phone = $phone_number;
		}	
		
		
		$data_customer_data = array(
			'userId'=> 'SADWEB-'.$order->user->id,
			'phoneNumber'=> $customer_phone,
			'countryCode'=> "+91",
			'traits'=> array(
				'name'  => $shipping_detail['name'],
				'email' => $shipping_detail['email'],
			),
		); 
				
		$json_user_data = json_encode($data_customer_data);	
		
		//echo "<pre>";print_r($json_user_data);die;
		
		$whatsapp_res_user = self::whatsapp_user_track($json_user_data);
						
		$data_customer_value = array(
			'userId'=> 'SADWEB-'.$order->user->id,
			'phoneNumber'=> $customer_phone,
			'countryCode'=> "+91",
			"event" => "Order_Confirmation",
			'traits'=> array(
				'Cusromer Name' => $shipping_detail['name'],
				'Order ID'		=> $order->code,
			),
			'createdAt'=> $order->created_at,
		); 
				
		$json_customer_data = json_encode($data_customer_value);	
		$whatsapp_res_customer = self::whatsapp_order_notification($json_customer_data);
		
	}
	
	public static function sendWhatsappToSeller($order,$seller){    
				
		$seller_details = $seller->user->shop;
		$seller_email = $seller->user->email;
		
		$seller_user_data = array(
			'userId'=> 'SADWEB-'.$seller_details->id,
			'phoneNumber'=> $seller_details->phone,
			'countryCode'=> "+91",
			'traits'=> array(
				'name'  => $seller_details->name,
				'email' => $seller_details->name,
			),
		); 
				
		$json_seller_user_data = json_encode($seller_user_data);			
		self::whatsapp_user_track($json_seller_user_data);
						
		$send_whatsapp_seller = array(
			'userId'=> 'SADWEB-'.$seller_details->id,
			'phoneNumber'=> $seller_details->phone,
			'countryCode'=> "+91",
			"event" => "Vendor_Order_Confirmation",
			'traits'=> array(
				'Seller Name' 	=> $seller_details->name,
				'Order ID'		=> $order->code,
			),
			'createdAt'=> $order->created_at,
		); 
				
		$json_send_whatsapp_seller = json_encode($send_whatsapp_seller);
		self::whatsapp_order_notification($json_send_whatsapp_seller);
		
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

    public static function sendNotification($order, $order_status)
    {        
        if ($order->seller_id == \App\User::where('user_type', 'admin')->first()->id) {
            $users = User::findMany([$order->user->id, $order->seller_id]);
        } else {
            $users = User::findMany([$order->user->id, $order->seller_id, \App\User::where('user_type', 'admin')->first()->id]);
        }

        $order_notification = array();
        $order_notification['order_id'] = $order->id;
        $order_notification['order_code'] = $order->code;
        $order_notification['user_id'] = $order->user_id;
        $order_notification['seller_id'] = $order->seller_id;
        $order_notification['status'] = $order_status;

        Notification::send($users, new OrderNotification($order_notification));
    }

    public static function sendFirebaseNotification($req)
    {        
        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array
        (
            'to' => $req->device_token,
            'notification' => [
                'body' => $req->text,
                'title' => $req->title,
                'sound' => 'default' /*Default sound*/
            ],
            'data' => [
                'item_type' => $req->type,
                'item_type_id' => $req->id,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
            ]
        );

        //$fields = json_encode($arrayToSend);
        $headers = array(
            'Authorization: key=' . env('FCM_SERVER_KEY'),
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        curl_close($ch);

        $firebase_notification = new FirebaseNotification;
        $firebase_notification->title = $req->title;
        $firebase_notification->text = $req->text;
        $firebase_notification->item_type = $req->type;
        $firebase_notification->item_type_id = $req->id;
        $firebase_notification->receiver_id = $req->user_id;

        $firebase_notification->save();
    }
}
