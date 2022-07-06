<?php

namespace App\Http\Controllers;

use Cache;
use Excel;
use App\Shop;
use App\User;
use App\Order;
use App\Seller;
use App\Product;
use App\OrderDetail;
use App\LedgerExport;
use App\CommissionHistory;
use Illuminate\Support\Str;
use CoreComponentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Notifications\EmailVerificationNotification;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $approved = null;
        $sellers = Seller::whereIn('user_id', function ($query) {
            $query->select('id')
                ->from(with(new User)->getTable());
        })->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $sort_search = $request->search;						
			$user_ids = Shop::where(function ($user) use ($sort_search) {
				$user->where('name', 'like', '%' . $sort_search . '%');
			})->pluck('user_id')->toArray();
						
			if(empty($user_ids)) {
				$user_ids = User::where('user_type', 'seller')->where(function ($user) use ($sort_search) {
					$user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
				})->pluck('id')->toArray();
			}
						
            $sellers = $sellers->where(function ($seller) use ($user_ids) {
                $seller->whereIn('user_id', $user_ids);
            });
        }
        if ($request->approved_status != null) {
            $approved = $request->approved_status;
            $sellers = $sellers->where('verification_status', $approved);
        }
        $sellers = $sellers->paginate(15);
        return view('backend.sellers.index', compact('sellers', 'sort_search', 'approved'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (User::where('email', $request->email)->first() != null) {
            flash(translate('Email already exists!'))->error();
            return back();
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_type = "seller";
        $user->password = Hash::make($request->password);				
        $user->address = $request->address;
        $user->country = 'India';
        $user->state = $request->state;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;	
        $user->user_description = $request->user_description;	
        $user->pickup_address = $request->pickup_address;	
        $user->pickup_state = $request->pickup_state;
        $user->pickup_city = $request->pickup_city;
        $user->pickup_postal_code = $request->pickup_postal_code;	
        // $user->save();
		
        if ($user->save()) {
            if (get_setting('email_verification') != 1) {
                $user->email_verified_at = date('Y-m-d H:m:s');
            } else {
                $user->notify(new EmailVerificationNotification());
            }
            $user->save();

            $seller = new Seller;
            $seller->user_id = $user->id;			
			$seller->bank_name = $request->bank_name;
			$seller->bank_acc_name = $request->bank_acc_name;
			$seller->bank_acc_no = $request->bank_acc_no;
			$seller->account_type = $request->account_type;
			$seller->ifsc_code = $request->ifsc_code;
			$seller->branch = $request->branch;				
			
            if ($seller->save()) {
                $shop = new Shop;
                $shop->user_id = $user->id;
                $shop->name = $request->shop_name;
                $shop->phone = $request->phone;
                $shop->types_of_business = $request->types_of_business;
                $shop->gst_number = $request->gst_number;
                $shop->pan_number = $request->pan_number;
                $shop->address = $request->address;
                $shop->country = 'India';
                $shop->state = $request->state;
                $shop->city = $request->city;
                $shop->postal_code = $request->postal_code;			
                $shop->slug = Str::slug($request->name)."-". $user->id; 	
				$shop->save();

                flash(translate('Seller has been inserted successfully'))->success();
                return redirect()->route('sellers.index');
            }
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seller = Seller::findOrFail(decrypt($id));
        return view('backend.sellers.edit', compact('seller'));
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
        $user->user_description = $request->user_description;	
        $user->pickup_address = $request->pickup_address;	
        $user->pickup_state = $request->pickup_state;
        $user->pickup_city = $request->pickup_city;
        $user->pickup_postal_code = $request->pickup_postal_code;	 
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        Shop::where('user_id', $seller->user_id)->delete();

        Product::where('user_id', $seller->user_id)->delete();

        $orders = Order::where('user_id', $seller->user_id)->get();

        foreach ($orders as $key => $order) {
            OrderDetail::where('order_id', $order->id)->delete();
        }

        Order::where('user_id', $seller->user_id)->delete();

        User::destroy($seller->user->id);

        if (Seller::destroy($id)) {
            flash(translate('Seller has been deleted successfully'))->success();
            return redirect()->route('sellers.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_seller_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $seller_id) {
                $this->destroy($seller_id);
            }
        }

        return 1;
    }

    public function show_verification_request($id)
    {
        $seller = Seller::findOrFail($id);
        return view('backend.sellers.verification', compact('seller'));
    }

    public function approve_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 1;
        if ($seller->save()) {
            Cache::forget('verified_sellers_id');
            flash(translate('Seller has been approved successfully'))->success();
            return redirect()->route('sellers.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function reject_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 0;
        $seller->verification_info = null;
        if ($seller->save()) {
            Cache::forget('verified_sellers_id');
            flash(translate('Seller verification request has been rejected successfully'))->success();
            return redirect()->route('sellers.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }


    public function payment_modal(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        return view('backend.sellers.payment_modal', compact('seller'));
    }

    public function profile_modal(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        return view('backend.sellers.profile_modal', compact('seller'));
    }

    public function updateApproved(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        $seller->verification_status = $request->status;
        if ($seller->save()) {
            // CREATE WAREHOUSE
                $seller_details = DB::table('shops')->join('users','users.id','shops.user_id')->where('users.id',$seller->user_id)
                ->select('shops.phone','shops.city','shops.name','shops.postal_code','shops.address','shops.state','users.name','users.email','user.pickup_address'	
                ,'user.pickup_state','user.pickup_city','user.pickup_postal_code')->first();

                $data = array(			
                            'phone'=> preg_replace('/[; & # % ]+/', ' ', trim($seller_details->phone)),
                            'city'=> preg_replace('/[; & # % ]+/', ' ', trim($seller_details->pickup_city)),
                            'name'=> preg_replace('/[; & # % ]+/', ' ', trim($seller_details->name)),
                            'pin'=> preg_replace('/[; & # % ]+/', ' ', trim($seller_details->pickup_postal_code)),
                            'address'=> preg_replace('/[; & # % ]+/', ' ', trim($seller_details->pickup_address)),
                            'country'=> 'India',
                            'contact_person'=> preg_replace('/[; & # % ]+/', ' ', trim($seller_details->name)),
                            'email'=>preg_replace('/[; & # % ]+/', ' ', trim($seller_details->email)),
                            'registered_name'=> preg_replace('/[; & # % ]+/', ' ', trim($seller_details->name)),
                            'return_address'=> preg_replace('/[; & # % ]+/', ' ', trim($seller_details->pickup_address)),
                            'return_pin'=> preg_replace('/[; & # % ]+/', ' ', trim($seller_details->pickup_postal_code)),
                            'return_city'=> preg_replace('/[; & # % ]+/', ' ', trim($seller_details->pickup_city)),
                            'return_state'=> preg_replace('/[; & # % ]+/', ' ', trim($seller_details->pickup_state)),
                            'return_country'=> 'India',
                        );
                  
                $response = Http::withHeaders([
                    "content-type"=> "application/json",
                    "Accept" => "application/json",
                    "Authorization"=> "Token 13e6e16ea6506989bb0d3fbaef437402278bffeb",
                ])->post('https://track.delhivery.com/api/backend/clientwarehouse/create/',$data);
            // CREATE WAREHOUSE
                
               
                if($response->json('success') == true){
                    return [
                        'status'=>$request->status,
                        'api_status'=>1,
                        'message'=> $response->json('data')['message']
                    ];
                }
                else{
                    return [
                        'status'=>$request->status,
                        'api_status'=>0,
                        'message'=>$response->json('error')[0]
                    ];
                }
        }
        return [
            'status'=>0,
            'api_status'=>0,
            'message'=>"Something Went Wrong"
        ];
    }

    public function login($id)
    {
        $seller = Seller::findOrFail(decrypt($id));

        $user  = $seller->user;

        auth()->login($user, true);

        return redirect()->route('dashboard');
    }

    public function ban($id)
    {
        $seller = Seller::findOrFail($id);

        if ($seller->user->banned == 1) {
            $seller->user->banned = 0;
            flash(translate('Seller has been unbanned successfully'))->success();
        } else {
            $seller->user->banned = 1;
            flash(translate('Seller has been banned successfully'))->success();
        }

        $seller->user->save();
        return back();
    }

    public function seller_account(Request $request)
	{
		if($request->submit_type == 'export') {	
			return Excel::download(new LedgerExport($request->seller_id,$request->order_date,$request->delivered_date,$request->delivery_status,$request->search), 'ledger.xlsx');
		}else{		
			CoreComponentRepository::instantiateShopRepository();

			$order_date = $request->order_date;
			$delivered_date = $request->delivered_date;
			$seller_id = $request->seller_id;
			$payment_status = null;
			$delivery_status = null;
			$sort_search = null;
			
			$orders_ledger = CommissionHistory::orderBy('id', 'desc');		

			if ($request->payment_type != null) {
				$orders_ledger = $orders_ledger->where('payment_status', $request->payment_type);
				$payment_status = $request->payment_type;
			}
			if ($request->delivery_status != null) {
				$orders_ledger = $orders_ledger->where('delivery_status', $request->delivery_status);
				$delivery_status = $request->delivery_status;
			}
			if ($request->has('search')) {
				$sort_search = $request->search;
				$orders_ledger = $orders_ledger->where('code', 'like', '%' . $sort_search . '%');
			}
			
			if ($order_date) {			
				$date_from = date('Y-m-d', strtotime(explode(" to ", $order_date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $order_date)[1]));			
				$orders_ledger = $orders_ledger->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}
			
			if ($delivered_date) {			
				$date_from = date('Y-m-d', strtotime(explode(" to ", $delivered_date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $delivered_date)[1]));			
				$orders_ledger = $orders_ledger->whereBetween('delivered_date', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}
						
			if ($seller_id) {
				$orders_ledger = $orders_ledger->where('seller_id', $seller_id);
			}

			$orders_ledger = $orders_ledger->paginate(10);
			return view('backend.sellers.seller_account.index', compact('orders_ledger', 'payment_status', 'delivery_status', 'sort_search', 'seller_id', 'order_date','delivered_date')); 
		}
	}
	
	public function bulk_order_pay(Request $request)
    {	
		if ($request->id) {
			$orders_pay_amount = CommissionHistory::whereIn('id', $request->id)->get();
        }				
		return view('backend.sellers.seller_account.payment_modal', compact('orders_pay_amount'));	 
		
    }
}
