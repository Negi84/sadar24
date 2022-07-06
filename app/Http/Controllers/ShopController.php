<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\User;
use App\Seller;
use App\BusinessSetting;
use Illuminate\Support\Str;
use Auth;
use Hash;
use App\Notifications\EmailVerificationNotification;

class ShopController extends Controller
{

    public function __construct()
    {
        $this->middleware('user', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user();
        // dd($shop,Auth::user());
        return view('frontend.user.seller.shop', compact('shop'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check() && Auth::user()->user_type == 'admin'){
            flash(translate('Admin can not be a seller'))->error();
            return back();
        }
        else{
            return view('frontend.seller_form');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = null;
        if(!Auth::check()){
            if(User::where('email', $request->email)->first() != null){
                flash(translate('Email already exists!'))->error();
                return back();
            }
            if($request->password == $request->password){
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
                $user->save();
            }
            else{
                flash(translate('Sorry! Password did not match.'))->error();
                return back();
            }
        }
        else{
            $user = Auth::user();
            if($user->customer != null){
                $user->customer->delete();
            }
            $user->user_type = "seller";
            $user->save();
        }

        if(Seller::where('user_id', $user->id)->first() == null){
        $seller = new Seller;
        $seller->user_id = $user->id;
        $seller->bank_name = $request->bank_name;
        $seller->bank_acc_name = $request->bank_acc_name;
        $seller->bank_acc_no = $request->bank_acc_no;
        $seller->account_type = $request->account_type;
        $seller->ifsc_code = $request->ifsc_code;
        $seller->branch = $request->branch;
        $seller->save();
        }

        if(Shop::where('user_id', $user->id)->first() == null){
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
            if($shop->save()){
                auth()->login($user, false);
                if(BusinessSetting::where('type', 'email_verification')->first()->value != 1){
                    $user->email_verified_at = date('Y-m-d H:m:s');
                    $user->save();
                }
                else {
                    $user->notify(new EmailVerificationNotification());
                }

                flash(translate('Your Shop has been created successfully!'))->success();
                $shop = Auth::user();
                // dd($shop,Auth::user());
                return view('frontend.user.seller.shop', compact('shop'));
                // return redirect()->route('shop.verify.store');
            }
            else{
                $seller->delete();
                $user->user_type == 'customer';
                $user->save();
            }
        }

        flash(translate('Sorry! Something went wrong.'))->error();
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
        //
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
        $shop = Shop::find($id);
		
		//echo "<pre>";print_r($shop->user->seller);die;

		//dd($request->all());die;


        if($request->has('name') && $request->has('address')){
            if ($request->has('shipping_cost')) {
                $shop->shipping_cost = $request->shipping_cost;
            }
            
            $shop->name             = $request->name;
            $shop->address          = $request->address;
            $shop->phone            = $request->phone;
            $shop->slug             = preg_replace('/\s+/', '-', $request->name).'-'.$shop->id;
            $shop->meta_title       = $request->meta_title;
            $shop->meta_description = $request->meta_description;
            $shop->logo             = $request->logo;
									
			$seller = $shop->user->seller;
			//$seller->cash_on_delivery_status = $request->cash_on_delivery_status;
			//$seller->bank_payment_status = $request->bank_payment_status;
			$seller->bank_name = $request->bank_name;
			$seller->bank_acc_name = $request->bank_acc_name;
			$seller->bank_acc_no = $request->bank_acc_no;
			$seller->account_type = $request->account_type;
			$seller->ifsc_code = $request->ifsc_code;
			$seller->branch = $request->branch;

			
            if ($request->has('pick_up_point_id')) {
                $shop->pick_up_point_id = json_encode($request->pick_up_point_id);
            }
            else {
                $shop->pick_up_point_id = json_encode(array());
            }						
			
        }

        if($request->has('delivery_pickup_longitude') && 
            $request->has('delivery_pickup_latitude')) {

            $shop->delivery_pickup_longitude    = $request->delivery_pickup_longitude;
            $shop->delivery_pickup_latitude     = $request->delivery_pickup_latitude;

        }

        elseif($request->has('facebook') || $request->has('google') || $request->has('twitter') || $request->has('youtube') || $request->has('instagram')){
            $shop->facebook = $request->facebook;
            $shop->google = $request->google;
            $shop->twitter = $request->twitter;
            $shop->youtube = $request->youtube;
        }

        else{
            $shop->sliders = $request->sliders;
        }

        if($shop->save() && $seller->save()){
            flash(translate('Your Shop has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
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
        //
    }

    public function verify_form(Request $request)
    {
        if(Auth::user()->seller->verification_info == null){
            $shop = Auth::user()->shop;
            return view('frontend.user.seller.verify_form', compact('shop'));
        }
        else {
            flash(translate('Sorry! You have sent verification request already.'))->error();
            return back();
        }
    }

    public function verify_form_store(Request $request)
    {
        $data = array();
        $i = 0;
        foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
            $item = array();
            if ($element->type == 'text') {
                $item['type'] = 'text';
                $item['label'] = $element->label;
                $item['value'] = $request['element_'.$i];
            }
            elseif ($element->type == 'select' || $element->type == 'radio') {
                $item['type'] = 'select';
                $item['label'] = $element->label;
                $item['value'] = $request['element_'.$i];
            }
            elseif ($element->type == 'multi_select') {
                $item['type'] = 'multi_select';
                $item['label'] = $element->label;
                $item['value'] = json_encode($request['element_'.$i]);
            }
            elseif ($element->type == 'file') {
                $item['type'] = 'file';
                $item['label'] = $element->label;
                $item['value'] = $request['element_'.$i]->store('uploads/verification_form');
            }
            array_push($data, $item);
            $i++;
        }
        $seller = Auth::user()->seller;
        $seller->verification_info = json_encode($data);
        if($seller->save()){
            flash(translate('Your shop verification request has been submitted successfully!'))->success();
            return redirect()->route('dashboard');
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }
}
