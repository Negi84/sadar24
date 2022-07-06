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


class OrderController extends Controller
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
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $orders = DB::table('orders')
        ->orderBy('id', 'desc')
            //->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->where('seller_id', Auth::user()->id)
        ->where('payment_status', '!=', 'failed')
        // ->where('payment_status', '!=', 'unpaid')
        ->select('orders.id')
		->take(200)
        ->distinct();

        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }

        $orders = $orders->paginate(15);

        foreach ($orders as $key => $value) {
            $order = \App\Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }

        return view('frontend.user.seller.orders', compact('orders', 'payment_status', 'delivery_status', 'sort_search'));
    }
	
	
	/*ready to ship*/
    public function readyToShip($id){
        $order = Order::findOrFail(decrypt($id));
        if ($order != null) {
            foreach ($order->orderDetails as $key => $orderDetail) {	
                $expectedCount = $orderDetail->quantity;				
				$seller = Shop::where('user_id', $orderDetail->seller_id)->first();				
				$shipping_detail = json_decode($order->shipping_address,true);				
				$payment_mode = $order->payment_type == 'cash_on_delivery'?'COD':'Pre-paid';
				$total_amount = round($order->grand_total, 2);
				
				$phone_number = preg_replace('/\s+/', '', $shipping_detail['phone']);
				$phone_number_length  =   strlen($phone_number);
				
				if($phone_number_length >10){
					$country_code = '+91';				
					$customer_phone = preg_replace("/^\+?{$country_code}/", '',$phone_number);
				}else{
					$customer_phone = $phone_number;
				}
				
				if ($seller) {					
					$data_ship = array(				
						"return_name"=>  preg_replace('/[; & # % ]+/', ' ', trim($seller->name)),
						"return_pin"=>  preg_replace('/[; & # % ]+/', ' ', trim($seller->postal_code)),
						"return_city"=>  preg_replace('/[; & # % ]+/', ' ', trim($seller->city)),
						"return_phone"=>  preg_replace('/[; & # % ]+/', ' ', trim($seller->phone)),
						"return_add"=> preg_replace('/[; & # % ]+/', ' ', trim($seller->address)),
						"return_state"=>  preg_replace('/[; & # % ]+/', ' ', trim($seller->state)),
						"return_country"=> preg_replace('/[; & # % ]+/', ' ', trim("India")),					
						"order"=>  preg_replace('/[; & # % ]+/', ' ', trim($order->code)),					
						"phone"=>  preg_replace('/[; & # % ]+/', ' ', trim($customer_phone)),
						"products_desc"=>  preg_replace('/[; & # % ]+/', ' ', trim($orderDetail->product->getTranslation('name'))),
						"cod_amount"=> $total_amount,	
						"name"=>  preg_replace('/[; & # % ]+/', ' ', trim($shipping_detail['name'])),
						"country"=> preg_replace('/[; & # % ]+/', ' ', trim("India")),
						"waybill"=> "",
						"seller_inv_date"=>  preg_replace('/[; & # % ]+/', ' ', trim($orderDetail->created_at)),
						"order_date"=>  preg_replace('/[; & # % ]+/', ' ', trim($orderDetail->created_at)),
						"total_amount"=> $total_amount,	
						"seller_add"=> preg_replace('/[; & # % ]+/', ' ', trim($seller->address)),
						"seller_cst"=> "",
						"add"=>  preg_replace('/[; & # % ]+/', ' ', trim($shipping_detail['address'])),
						"seller_name"=> preg_replace('/[; & # % ]+/', ' ', trim($seller->name)),
						"seller_inv"=>  preg_replace('/[; & # % ]+/', ' ', trim($order->code)),
						"seller_tin"=> "",
						"pin"=>  preg_replace('/[; & # % ]+/', ' ', trim($shipping_detail['postal_code'])),
						"quantity"=> $orderDetail->quantity,
						"payment_mode"=>  preg_replace('/[; & # % ]+/', ' ', trim($payment_mode)),
						"state"=>  preg_replace('/[; & # % ]+/', ' ', trim($shipping_detail['state'])),
						"city"=>  preg_replace('/[; & # % ]+/', ' ', trim($shipping_detail['city'])),
						"client"=> preg_replace('/[; & # % ]+/', ' ', trim('SADAR24 SURFACE')),
					);
					
					$data_pin = array(
						'pincode'=> preg_replace('/[; & # % ]+/', ' ', trim($seller->postal_code)),
						'add'=> preg_replace('/[; & # % ]+/', ' ', trim($seller->address)),
						'phone'=> preg_replace('/[; & # % ]+/', ' ', trim($seller->phone)),
						'state'=> preg_replace('/[; & # % ]+/', ' ', trim($seller->state)),
						'city'=> preg_replace('/[; & # % ]+/', ' ', trim($seller->city)),
						'country'=>preg_replace('/[; & # % ]+/', ' ', trim('India')),
						'name'=> preg_replace('/[; & # % ]+/', ' ', trim($seller->name)),
					); 
					
					$data_ship_js = json_encode($data_ship);
					$data_pin_json = json_encode($data_pin);				
					
					$json_data = 'format=json&data={
						"pickup_location": '.$data_pin_json.',
						"shipments": [
							'.$data_ship_js.'
						]
					}';
					$ord_res = $this->delhivery_create_order($json_data);
					//echo "<pre>";print_r($ord_res);die;					
					$pcdata = $ord_res['packages'];
					if($pcdata !=NULL){
						foreach($pcdata as $datas)
						{						
							$order->waybill = $datas['waybill'];
							$order->save();	
						}
						flash(translate('Order data is successfully shipped to delhivery'))->success();
					}else{
						flash(translate('Something went wrong'))->error();
					}
					return back();
				}else{
					flash(translate('Something went wrong'))->error();
				}
			}
		}
	}
			
	/*packing slip*/
	public function packingSlip($id){
		$order = Order::findOrFail(decrypt($id));
		$slip = $this->delhivery_packing_slip(['wbns' => $order->waybill]);
		return view('frontend.user.seller.packing_slip', compact('slip','order'));
	}	
	
	public function delhivery_packing_slip($data){
		$url = $this->delhiveryEndpoint.'api/p/packing_slip';
		$response = getCurl($url,$data);
		$packingSlip = json_decode($response, true);		
		return $packingSlip;
	}
	
	/*return order*/
	public function returnOrder($id)
	{
		$isShip = false;
		$waybill = '';
		$order = Order::findOrFail(decrypt($id));
		if ($order != null) {
			foreach ($order->orderDetails as $key => $orderDetail) 
			{
				$expectedCount = $orderDetail->quantity;
				$sd = Seller::select('verification_info')->first($orderDetail->seller_id);
				$seller = json_decode($sd->verification_info,true);
				if ($seller) {
					$isShip = true;
					$sellerDetail = [];
					if ($order->payment_type == 'cash_on_delivery') {
						$sellerDetail['cod_amount'] = $order->grand_total;
					}
					/*seller info*/
					foreach ($seller as $key => $value) {

						if ($value['label'] == 'Full Address') {
							$sellerDetail['seller_add'] = $value['value'];
							$sellerDetail['add'] = $value['value'];
						}
						if ($value['label'] == 'state') {
							$sellerDetail['state'] = $value['value'];
						}
						if ($value['label'] == 'city') {
							$sellerDetail['city'] = $value['value'];
						}
						if ($value['label'] == 'Pin Code') {
							$sellerDetail['pin'] = $value['value'];
						}
						if ($value['label'] == 'Your name') {
							$sellerDetail['seller_name'] = $value['value'];
						}
					}
					$shipping_detail = json_decode($order->shipping_address,true);			

					$ord_data = [];
					$pickup_data = [];

					$ord_data['pickup_location'] = [
						'pin'   => $shipping_detail['postal_code'],
						'add'   =>  $shipping_detail['address'],
						'phone'   =>  $shipping_detail['phone'],
						'state'   =>  $shipping_detail['city'],
						'city'   =>  $shipping_detail['city'],
						'country'   =>  $shipping_detail['country']
					];

					$ord_data['shipments'] = [[
						'order' => $order->code.$orderDetail->product_id,
						'phone' => $shipping_detail['phone'],
						'products_desc' => $orderDetail->product->getTranslation('name'),
						'name' =>  $shipping_detail['name'],
						'country' =>  $shipping_detail['country'],
						'seller_inv_date' =>  'invoice_date',
						'order_date' =>  date('Y-m-d H:i:s', strtotime($order->date)),
						'total_amount' => $order->grand_total,				
						'quantity' =>  $orderDetail->quantity,
						'payment_mode' =>  ($order->payment_type == 'cash_on_delivery')?'COD':'Pre-paid',
						$sellerDetail,
						'client' =>  env('DELHIVERY_CLIENT_NAME')
					]];
					if ($isShip) {

						$ord_res = $this->delhivery_create_order($ord_data);

						$pickup_data['pickup_time'] = date('H:i:s');
						$pickup_data['pickup_date'] = date('Y-m-d');
						$pickup_data['pickup_location'] = $sellerDetail['seller_add'];
						$pickup_data['expected_package_count'] = $expectedCount; //1 or 2 etc
						$pickup_res = $this->delhivery_pickup_order($pickup_data);
						$order->waybill = $waybill;
						$order->save();
					}
				}
			}
		}

		/*create order*/

		if ($isShip) {
				//flash(translate('Your pickup request created successfully!'))->success();
				//return redirect()->back();
		}else{
				//flash(translate('Unable to set ready to ship. Please check your order and seller information!'))->error();
				//return redirect()->back();
		}
	}

	/*track order*/
	public function trackOrder($id)
	{
		$order = Order::findOrFail(decrypt($id));
		$track_data = $this->delhivery_track_order(['waybill' => $order->waybill]);
		dd($track_data);
	}

	public function delhivery_get_waybill()
	{
		$url = $this->delhiveryEndpoint.'waybill/api/fetch/json/';
		$data = [];
		$data['cl'] = env('DELHIVERY_CLIENT_NAME');
		$response = getCurl($url,$data);
		$response = json_decode($response, true);
		dd($response);
	}

	public function delhivery_create_order($data)
	{  
		$url = $this->delhiveryEndpoint.'api/cmu/create.json';
		$response = postCurl($url,$data);
		$response = json_decode($response, true);
		return $response;
	}
	
	public function delhivery_pickup_order($data)
	{
		$url = $this->delhiveryEndpoint.'fm/request/new/';
		$data = json_encode($data);
		$response = postCurl($url,$data);
		$response = json_decode($response, true);
		dd($response);
	}

	public function delhivery_track_order($data)
	{
		$url = $this->delhiveryEndpoint.'api/v1/packages/json/';
		$response = getCurl($url,$data);
		$response = json_decode($response, true);		
		return $response;
	   // dd($response);
	}

    // All Orders
	public function all_orders(Request $request)
	{
		CoreComponentRepository::instantiateShopRepository();	
		if($request->submit_type == 'export') {		
			return Excel::download(new OrderExport($request->date,$request->delivery_status), 'sales.xlsx');
		}
		else{

			$date = $request->date;
			$sort_search = null;
			$delivery_status = null;

			$orders = Order::orderBy('id', 'desc');
			if ($request->has('search')) {
				$sort_search = $request->search;
				$orders = $orders->where('code', 'like', '%' . $sort_search . '%');
			}
			if ($request->delivery_status != null) {
				$orders = $orders->where('delivery_status', $request->delivery_status);
				$delivery_status = $request->delivery_status;
			}
			
			if ($date != null) {	
				$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
				$orders = $orders->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}	
			$orders = $orders->paginate(15);
			return view('backend.sales.all_orders.index', compact('orders', 'sort_search', 'delivery_status', 'date'));
		}
	}

	public function all_orders_show($id)
	{
		$order = Order::findOrFail(decrypt($id));
		$order_shipping_address = json_decode($order->shipping_address);
		$delivery_boys = User::where('city', $order_shipping_address->city)
		->where('user_type', 'delivery_boy')
		->get();
		return view('backend.sales.all_orders.show', compact('order', 'delivery_boys'));
	}

	// Inhouse Orders
	public function admin_orders(Request $request)
	{
		CoreComponentRepository::instantiateShopRepository();

		$date = $request->date;
		$payment_status = null;
		$delivery_status = null;
		$sort_search = null;
		$admin_user_id = User::where('user_type', 'admin')->first()->id;
		$orders = Order::orderBy('id', 'desc')->where('seller_id', $admin_user_id);
		if ($request->payment_type != null) {
			$orders = $orders->where('payment_status', $request->payment_type);
			$payment_status = $request->payment_type;
		}
		if ($request->delivery_status != null) {
			$orders = $orders->where('delivery_status', $request->delivery_status);
			$delivery_status = $request->delivery_status;
		}
		if ($request->has('search')) {
			$sort_search = $request->search;
			$orders = $orders->where('code', 'like', '%' . $sort_search . '%');
		}
		if ($date != null) {
			$orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
		}
		$orders = $orders->paginate(15);
		return view('backend.sales.inhouse_orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'admin_user_id', 'date'));
	}

	public function show($id)
	{
		$order = Order::findOrFail(decrypt($id));
		$order_shipping_address = json_decode($order->shipping_address);
		$delivery_boys = User::where('city', $order_shipping_address->city)->where('user_type', 'delivery_boy')->get();
		$order->viewed = 1;
		$order->save();
		return view('backend.sales.inhouse_orders.show', compact('order', 'delivery_boys'));
	}

	// Seller Orders
	public function seller_orders(Request $request)
	{
		CoreComponentRepository::instantiateShopRepository();

		$date = $request->date;
		$seller_id = $request->seller_id;
		$payment_status = null;
		$delivery_status = null;
		$sort_search = null;
		$admin_user_id = User::where('user_type', 'admin')->first()->id;
		$orders = Order::orderBy('id', 'desc')
		->where('orders.seller_id', '!=', $admin_user_id);
		$orders = $orders->where('payment_status','!=', 'failed');

		if ($request->payment_type != null) {
			$orders = $orders->where('payment_status', $request->payment_type);
			$payment_status = $request->payment_type;
		}
		if ($request->delivery_status != null) {
			$orders = $orders->where('delivery_status', $request->delivery_status);
			$delivery_status = $request->delivery_status;
		}
		if ($request->has('search')) {
			$sort_search = $request->search;
			$orders = $orders->where('code', 'like', '%' . $sort_search . '%');
		}
		if ($date != null) {
			$orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
		}
		if ($seller_id) {
			$orders = $orders->where('seller_id', $seller_id);
		}

		$orders = $orders->paginate(15);
		return view('backend.sales.seller_orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'admin_user_id', 'seller_id', 'date'));
	}

	public function seller_orders_show($id)
	{
		$order = Order::findOrFail(decrypt($id));
		$order->viewed = 1;
		$order->save();
		return view('backend.sales.seller_orders.show', compact('order'));
	}



	// Seller Orders Account
	public function seller_account(Request $request)
	{
		CoreComponentRepository::instantiateShopRepository();

		$date = $request->date;
		$seller_id = $request->seller_id;
		$payment_status = null;
		$delivery_status = null;
		$sort_search = null;
		$admin_user_id = User::where('user_type', 'admin')->first()->id;
		
		$orders = Order::orderBy('id', 'desc')
		->where('orders.seller_id', '!=', $admin_user_id);
		//->where('orders.seller_id', '=', 705);

		if ($request->payment_type != null) {
			$orders = $orders->where('payment_status', $request->payment_type);
			$payment_status = $request->payment_type;
		}
		if ($request->delivery_status != null) {
			$orders = $orders->where('delivery_status', $request->delivery_status);
			$delivery_status = $request->delivery_status;
		}
		if ($request->has('search')) {
			$sort_search = $request->search;
			$orders = $orders->where('code', 'like', '%' . $sort_search . '%');
		}
		if ($date != null) {
			$orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
		}
		if ($seller_id) {
			$orders = $orders->where('seller_id', $seller_id);
		}

		$orders = $orders->paginate(25);
		return view('backend.sales.seller_account.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'admin_user_id', 'seller_id', 'date'));
	}




    // Pickup point orders
	public function pickup_point_order_index(Request $request)
	{
		$date = $request->date;
		$sort_search = null;

		if (Auth::user()->user_type == 'staff' && Auth::user()->staff->pick_up_point != null) {
			$orders = DB::table('orders')
			->orderBy('code', 'desc')
			->join('order_details', 'orders.id', '=', 'order_details.order_id')
			->where('order_details.pickup_point_id', Auth::user()->staff->pick_up_point->id)
			->select('orders.id')
			->distinct();

			if ($request->has('search')) {
				$sort_search = $request->search;
				$orders = $orders->where('code', 'like', '%' . $sort_search . '%');
			}
			if ($date != null) {
				$orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
			}

			$orders = $orders->paginate(15);

			return view('backend.sales.pickup_point_orders.index', compact('orders', 'sort_search', 'date'));
		} else {
			$orders = DB::table('orders')
			->orderBy('code', 'desc')
			->join('order_details', 'orders.id', '=', 'order_details.order_id')
			->where('order_details.shipping_type', 'pickup_point')
			->select('orders.id')
			->distinct();

			if ($request->has('search')) {
				$sort_search = $request->search;
				$orders = $orders->where('code', 'like', '%' . $sort_search . '%');
			}
			if ($date != null) {
				$orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
			}

			$orders = $orders->paginate(15);

			return view('backend.sales.pickup_point_orders.index', compact('orders', 'sort_search', 'date'));
		}
	}

	public function pickup_point_order_sales_show($id)
	{
		if (Auth::user()->user_type == 'staff') {
			$order = Order::findOrFail(decrypt($id));
			$order_shipping_address = json_decode($order->shipping_address);
			$delivery_boys = User::where('city', $order_shipping_address->city)
			->where('user_type', 'delivery_boy')
			->get();

			return view('backend.sales.pickup_point_orders.show', compact('order', 'delivery_boys'));
		} else {
			$order = Order::findOrFail(decrypt($id));
			$order_shipping_address = json_decode($order->shipping_address);
			$delivery_boys = User::where('city', $order_shipping_address->city)
			->where('user_type', 'delivery_boy')
			->get();

			return view('backend.sales.pickup_point_orders.show', compact('order', 'delivery_boys'));
		}
	}

    /**
     * Display a single sale to admin.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $carts = Cart::where('user_id', Auth::user()->id)
        ->get();
        if ($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
            return redirect()->route('home');
        }
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        $shipping_info->name = Auth::user()->name;
        $shipping_info->email = Auth::user()->email;
        if ($shipping_info->latitude || $shipping_info->longitude) {
            $shipping_info->lat_lang = $shipping_info->latitude . ',' . $shipping_info->longitude;
        }
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
			$last_orderid = $get_orderid ->id +1 ;
            $order = new Order;
            $order->combined_order_id = $combined_order->id;
            $order->user_id = Auth::user()->id;
            $order->shipping_address = json_encode($shipping_info);
            $order->payment_type = $request->payment_option;
            $order->delivery_viewed = '0';
            $order->payment_status_viewed = '0';
            $order->code = date('Ym') . $last_orderid;
            $order->date = strtotime('now');
            $order->device_type = 'Website';
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
                $product_stock = $product->stocks->where('product_id', $cartItem['product_id'])->first();
                if ($product->digital != 1 && $cartItem['quantity'] > $product_stock->qty) {
                    flash(translate('The requested quantity is not available for ') . $product->getTranslation('name'))->warning();
                    $order->delete();
                    return redirect()->route('cart')->send();
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
			
			$order->grand_total = $subtotal + $tax + $shipping;
            
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
        $request->session()->put('combined_order_id', $combined_order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                try {

                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)->where('variant', $orderDetail->variation)->first();
                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }

                } catch (\Exception $e) {

                }

                $orderDetail->delete();
            }
            $order->delete();
            flash(translate('Order has been deleted successfully'))->success();
        } else {
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }
    
    public function cancel($id)
    {
		$order = Order::findOrFail($id);
        $order->delivery_status = 'cancelled';
        $order->save();	
        if ($order != null) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->delivery_status = 'cancelled';
                $orderDetail->save();
            }
            flash(translate('Order has been cancelled successfully'))->success();
        } else {
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }
    
    public function bulk_order_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $order_id) {
                $this->destroy($order_id);
            }
        }
        return 1;
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->save();
        return view('frontend.user.seller.order_details_seller', compact('order'));
    }
	
	public function seller_order_details($id)
    {
        $order = Order::findOrFail(decrypt($id));       
        $order->save();
		return view('frontend.user.seller.order_details_seller', compact('order'));;
    }
	

    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        $order->delivery_status = $request->status;
        $order->save();

        if ($request->status == 'cancelled' && $order->payment_type == 'wallet') {
            $user = User::where('id', $order->user_id)->first();
            $user->balance += $order->grand_total;
            $user->save();
        }

        if (Auth::user()->user_type == 'seller') {
            foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();

                if ($request->status == 'cancelled') {
                    $variant = $orderDetail->variation;
                    if ($orderDetail->variation == null) {
                        $variant = '';
                    }

                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
                    ->where('variant', $variant)
                    ->first();

                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }
                }
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {

                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();

                if ($request->status == 'cancelled') {
                    $variant = $orderDetail->variation;
                    if ($orderDetail->variation == null) {
                        $variant = '';
                    }

                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
                    ->where('variant', $variant)
                    ->first();

                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }
                }

                if (addon_is_activated('affiliate_system')) {
                    if (($request->status == 'delivered' || $request->status == 'cancelled') &&
                        $orderDetail->product_referral_code) {

                        $no_of_delivered = 0;
                    $no_of_canceled = 0;

                    if ($request->status == 'delivered') {
                        $no_of_delivered = $orderDetail->quantity;
                    }
                    if ($request->status == 'cancelled') {
                        $no_of_canceled = $orderDetail->quantity;
                    }

                    $referred_by_user = User::where('referral_code', $orderDetail->product_referral_code)->first();

                    $affiliateController = new AffiliateController;
                    $affiliateController->processAffiliateStats($referred_by_user->id, 0, 0, $no_of_delivered, $no_of_canceled);
                }
            }
        }
    }
    if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'delivery_status_change')->first()->status == 1) {
        try {
            SmsUtility::delivery_status_change(json_decode($order->shipping_address)->phone, $order);
        } catch (\Exception $e) {

        }
    }

        //sends Notifications to user
    NotificationUtility::sendNotification($order, $request->status);
    if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
        $request->device_token = $order->user->device_token;
        $request->title = "Order updated !";
        $status = str_replace("_", "", $order->delivery_status);
        $request->text = " Your order {$order->code} has been {$status}";

        $request->type = "order";
        $request->id = $order->id;
        $request->user_id = $order->user->id;

        NotificationUtility::sendFirebaseNotification($request);
    }


    if (addon_is_activated('delivery_boy')) {
        if (Auth::user()->user_type == 'delivery_boy') {
            $deliveryBoyController = new DeliveryBoyController;
            $deliveryBoyController->store_delivery_history($order);
        }
    }

    return 1;
}

	/*public function bulk_order_status(Request $request) {
	   //dd($request->all());
	   if($request->id) {
			foreach ($request->id as $order_id) {
				$order = Order::findOrFail($order_id);
				$order->delivery_viewed = '0';
				$order->save();	
				$this->change_status($order, $request);
			}
		}	
	    return 1;
	}*/

	public function update_payment_status(Request $request)
	{
		$order = Order::findOrFail($request->order_id);
		$order->payment_status_viewed = '0';
		$order->save();

		if (Auth::user()->user_type == 'seller') {
			foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
				$orderDetail->payment_status = $request->status;
				$orderDetail->save();
			}
		} else {
			foreach ($order->orderDetails as $key => $orderDetail) {
				$orderDetail->payment_status = $request->status;
				$orderDetail->save();
			}
		}

		$status = 'paid';
		foreach ($order->orderDetails as $key => $orderDetail) {
			if ($orderDetail->payment_status != 'paid') {
				$status = 'unpaid';
			}
		}
		$order->payment_status = $status;
		$order->save();


		if ($order->payment_status == 'paid' && $order->commission_calculated == 0) {
			calculateCommissionAffilationClubPoint($order);
		}

			//sends Notifications to user
		NotificationUtility::sendNotification($order, $request->status);
		if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
			$request->device_token = $order->user->device_token;
			$request->title = "Order updated !";
			$status = str_replace("_", "", $order->payment_status);
			$request->text = " Your order {$order->code} has been {$status}";

			$request->type = "order";
			$request->id = $order->id;
			$request->user_id = $order->user->id;

			NotificationUtility::sendFirebaseNotification($request);
		}


		if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'payment_status_change')->first()->status == 1) {
			try {
				SmsUtility::payment_status_change(json_decode($order->shipping_address)->phone, $order);
			} catch (\Exception $e) {

			}
		}
		return 1;
	}

	public function assign_delivery_boy(Request $request)
	{
		if (addon_is_activated('delivery_boy')) {

			$order = Order::findOrFail($request->order_id);
			$order->assign_delivery_boy = $request->delivery_boy;
			$order->delivery_history_date = date("Y-m-d H:i:s");
			$order->save();

			$delivery_history = \App\DeliveryHistory::where('order_id', $order->id)
			->where('delivery_status', $order->delivery_status)
			->first();

			if (empty($delivery_history)) {
				$delivery_history = new \App\DeliveryHistory;

				$delivery_history->order_id = $order->id;
				$delivery_history->delivery_status = $order->delivery_status;
				$delivery_history->payment_type = $order->payment_type;
			}
			$delivery_history->delivery_boy_id = $request->delivery_boy;

			$delivery_history->save();

			if (env('MAIL_USERNAME') != null && get_setting('delivery_boy_mail_notification') == '1') {
				$array['view'] = 'emails.invoice';
				$array['subject'] = translate('You are assigned to delivery an order. Order code') . ' - ' . $order->code;
				$array['from'] = env('MAIL_FROM_ADDRESS');
				$array['order'] = $order;

				try {
					Mail::to($order->delivery_boy->email)->queue(new InvoiceEmailManager($array));
				} catch (\Exception $e) {

				}
			}

			if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'assign_delivery_boy')->first()->status == 1) {
				try {
					SmsUtility::assign_delivery_boy($order->delivery_boy->phone, $order->code);
				} catch (\Exception $e) {

				}
			}
		}

		return 1;
	}
}
