<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\OTPVerificationController;
use Illuminate\Http\Request;
use App\Http\Controllers\ClubPointController;
use App\Order;
use App\Cart;
use App\Address;
use App\Product;
use App\ProductStock;
use App\CommissionHistory;
use App\Color;
use App\OrderDetail;
use App\CouponUsage;
use App\Coupon;
use App\OtpConfiguration;
use App\User;
use App\Shop;
use App\Seller;
use App\Category;
use App\BusinessSetting;
use App\CombinedOrder;
use App\SmsTemplate;
use Auth;
use Session;
use DB;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\Utility\NotificationUtility;
use CoreComponentRepository;
use App\Utility\SmsUtility;
use App\OrderExport;
use Excel;
use Illuminate\Support\Str;


class OrderUpdateController extends Controller
{

    public $delhiveryEndpoint = '';

    public function __construct(){

        if (env('DELHIVERY_ENV') == 'Test') {
            $this->delhiveryEndpoint = env('DELHIVERY_TEST_ENDPOINT');
        }

        if (env('DELHIVERY_ENV') == 'Production') {
            $this->delhiveryEndpoint = env('DELHIVERY_PROD_ENDPOINT');
        }

    }

    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
	 
    public function index(Request $request)
    {
        
    }
	
	public function orders_delhivery_current_status(Request $request)
    {	
	
		$skip  = $request->skip;
		$limit = $request->limit;
		
		$orders = Order::orderBy('id', 'desc')->where('waybill', '!=', '')->offset($skip)->take($limit)->get();	
		//$orders = Order::orderBy('id', 'desc')->where('waybill', '!=', '')->where('delivery_status', '!=', 'cancelled')->where('delivery_status', '!=', 'delivered')->get();
		
		foreach($orders as $key => $order) {
			$track_data = $this->delhivery_track_order(['waybill' =>  $order->waybill]);	
            $tdata = $track_data["ShipmentData"];			
			foreach($tdata as $trackdata)
            {
				$order_id = $trackdata["Shipment"]["ReferenceNo"];
				$awb_no = $trackdata["Shipment"]["AWB"];
				$status = $trackdata["Shipment"]["Status"]["Status"];
				$statustype = $trackdata["Shipment"]["Status"]["StatusType"];
				$instructions = $trackdata["Shipment"]["Status"]["Instructions"];
				$statusDateTime = $trackdata["Shipment"]["Status"]["StatusDateTime"]; 
												
				if($order->delivery_status!=$status)
				{	
					if(Str::lower($status)== 'delivered'){
						$order->payment_status  = 'paid';
						$order->delivery_status = 'delivered';
					}else{
						$order->delivery_status = $instructions;
					}
					$order->delivery_viewed = '0';
					$order->updated_at  = $statusDateTime;
					$order->save();
					
					foreach ($order->orderDetails as $key => $orderDetail) 
					{
						$commission_history = CommissionHistory::firstWhere('order_detail_id', $orderDetail->id);	
						if(Str::lower($status) == 'delivered'){
							$orderDetail->payment_status  = 'paid';
							$orderDetail->delivery_status = 'delivered';							
							$commission_history->payment_status  = 'paid';
							$commission_history->delivery_status = 'delivered';							
						}else{
							$orderDetail->delivery_status = $instructions;
							$commission_history->delivery_status = $instructions;
						}
						$orderDetail->updated_at  = $statusDateTime;
						$orderDetail->save();
						
						$commission_history->delivered_date  = $statusDateTime;
						$commission_history->save();
					}		
				}			
            }
		}	
		echo "Order Status is updated.";		
    }
       
		
	public function delhivery_track_order($data){
		$url = $this->delhiveryEndpoint.'api/v1/packages/json/';
		$response = getCurl($url,$data);
		$response = json_decode($response, true);		
		return $response;
	} 	
	
	public function update_seller_order_history(Request $request)
    {	
		$orders = Order::orderBy('id', 'asc')->where('commission_calculated', 0)->take(1000)->get();		
		foreach($orders as $key => $order) {
			calculateCommissionAffilationClubPoint($order);
		} 
		echo "Order Statement is updated.";		
    }
	
	public function update_delhivery_date(Request $request)
    {
		
		$track_data = $this->delhivery_track_order(['waybill' =>  '11056810105615']);	
		$tdata = $track_data["ShipmentData"];
		echo "<pre>";print_r($tdata);die;
		
		$orders = Order::orderBy('id', 'asc')->where('waybill', '!=', '')->where('delivery_status', '!=', 'delivered')->get();
		
		foreach($orders as $key => $order) {	
		
			$track_data = $this->delhivery_track_order(['waybill' =>  $order->waybill]);	
            $tdata = $track_data["ShipmentData"];
           // echo "<pre>";print_r($tdata);
			foreach($tdata as $trackdata)
            {
				$order_id = $trackdata["Shipment"]["ReferenceNo"];
				$awb_no = $trackdata["Shipment"]["AWB"];
				$status = $trackdata["Shipment"]["Status"]["Status"];
				$statustype = $trackdata["Shipment"]["Status"]["StatusType"];
				$instructions = $trackdata["Shipment"]["Status"]["Instructions"];
				$statusDateTime = $trackdata["Shipment"]["Status"]["StatusDateTime"]; 
				foreach ($order->orderDetails as $key => $orderDetail) 
				{
					$commission_history = CommissionHistory::firstWhere('order_detail_id', $orderDetail->id);						
					if(Str::lower($status) == 'delivered'){
						$commission_history->payment_status  = 'paid';
						$commission_history->delivery_status = 'delivered';
						
					}else{
						$commission_history->delivery_status = $instructions;
					}
					$commission_history->delivered_date  = $statusDateTime;
					$commission_history->save();
				}	
			}			
		}		
		echo "Order Delhivery Date is updated.";		
    }
      
		
	public function update_wrong_shipping(Request $request)
    {
		$orderDetails = OrderDetail::orderBy('id', 'desc')->get();
		
		//echo "<pre>";print_r($orderDetails);die;
		
		foreach($orderDetails as $key => $orderDetail) {
			$shipping_cost = $orderDetail->shipping_cost * $orderDetail->quantity;
			$tax = $shipping_cost * 0.18;
			
			$orderDetail->shipping_cost  = $shipping_cost;
			$orderDetail->tax  = $tax;
			$orderDetail->save();
		}		
		echo "Shipping is updated."; 
    }
	public function update_invoice_total($orderid,$amount)
    {			
		$order = Order::firstWhere('code', $orderid);
		if($order){
			$order->grand_total = $amount;
			$order->save();		
			echo "Order Amount is updated.";		
		}else{
			echo "Sorry! Wrong Order id.";		
		}
		
    }
	
	public function clear_commission_histories(Request $request)
    {	
		$clear_comm = CommissionHistory::truncate();	
		if($clear_comm){
			echo "Commission History Clear.<br>";
			$set_calculated = DB::table('orders')->update(['commission_calculated' => 0]);
			if($set_calculated){
				echo "Commission Calculated Value set 0.<br>";				
			}else{
				echo "Sorry! Error in Commission Calculated<br>";		
			}
				
		}else{
			echo "Sorry! Error in Commission Tabel clear<br>";		
		}
    }
	public function update_category_for_product(Request $request)
    {	
		$category = Category::orderBy('id', 'desc')->where('replace_category', '!=', '')->get();
		foreach($category as $key => $category_data) {	
			$replace_category_string = preg_replace('/\s+/', '', $category_data->replace_category);
			$array_value = $myArray = explode('-', $replace_category_string);
			foreach($array_value as $key => $category_id) {
				Product::where('category_old', $category_id)->update(['category_id' => $category_data->id]);	
			}	
		}
		echo "All Done";
    }
	
	public function update_tags_for_product(Request $request)
    {	
		$category = Category::where('keywords', '!=', '')->orderBy('id', 'asc')->get();
		foreach($category as $key => $category_data) {
			$tags = preg_replace('/\s*,\s*/', ',', $category_data->keywords);
			Product::where('category_id', $category_data->id)->update(['tags' => $tags]);
		}
		echo "All Done";
    }
		
	public function get_product_category($catid)
    {	
		$product = Product::select('id', 'tags')->where('category_id', $catid)->orderBy('id', 'asc')->get();
		foreach($product as $key => $product_data) {
			$manage[] = $product_data->id;
		}
		$data = json_encode($manage, true);
		echo $data;
    }
	
	public function update_product_category($catid,$proid)
    {	
		$products = json_decode($proid, true);		
		foreach($products as $product_data) {
			Product::where('id', $product_data)->update(['category_id' => $catid]);	
		}
		echo "All category data done.";
    }
}
