<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Mail;
use Cache;
use Cookie;
use Session;
use App\Cart;
use App\Shop;
use App\User;
use App\Brand;
use App\Order;
use App\Coupon;
use App\Seller;
use App\Product;
use App\Category;
use App\FlashDeal;
use App\PickupPoint;
use App\BusinessSetting;
use App\CustomerPackage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Events\PasswordReset;
use App\Mail\SecondEmailVerifyMailManager;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailLoginNotification;


class HomeController extends Controller
{
    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $best_seller_category = [];
        $recommended_on_sadar = [];
        $featured_categories = [];
        $deal_of_the_day = [];
        $slider_images = [];
        if(json_decode(get_setting('best_seller_category_images'), true)!= null){
        $best_seller_category = Cache::rememberForever('best_seller_category', function () {
            for ($i=0; $i < count(json_decode(get_setting('best_seller_category_images'), true)) ; $i++) { 
                $best_seller_category[$i] = [
                    'best_seller_category_images'=> uploaded_asset(json_decode(get_setting('best_seller_category_images'), true)[$i]),
                    'best_seller_category_heading'=> json_decode(get_setting('best_seller_category_heading'), true)[$i],
                    'best_seller_category_offer'=> json_decode(get_setting('best_seller_category_offer'), true)[$i],
                    'best_seller_category_tag'=> json_decode(get_setting('best_seller_category_tag'), true)[$i],
                    'best_seller_category_links'=> json_decode(get_setting('best_seller_category_links'), true)[$i],
                ];
            }
            return $best_seller_category;           
        });
    }
        if(json_decode(get_setting('recommended_on_sadar_images'), true)!= null){
        $recommended_on_sadar = Cache::rememberForever('recommended_on_sadar', function () {
            for ($i=0; $i < count(json_decode(get_setting('recommended_on_sadar_images'), true)) ; $i++) { 
                $recommended_on_sadar[$i] = [
                    'recommended_on_sadar_images'=> uploaded_asset(json_decode(get_setting('recommended_on_sadar_images'), true)[$i]),
                    'recommended_on_sadar_links'=> json_decode(get_setting('recommended_on_sadar_links'), true)[$i],
                ];
            }
            return $recommended_on_sadar;          
        });
    }
        if(json_decode(get_setting('deal_of_the_day_images'), true)!= null){
        $deal_of_the_day = Cache::rememberForever('deal_of_the_day', function () {
            for ($i=0; $i < count(json_decode(get_setting('deal_of_the_day_images'), true)) ; $i++) { 
                $deal_of_the_day[$i] = [
                    'deal_of_the_day_images'=> uploaded_asset(json_decode(get_setting('deal_of_the_day_images'), true)[$i]),
                    'deal_of_the_day_heading'=> json_decode(get_setting('deal_of_the_day_heading'), true)[$i],
                    'deal_of_the_day_links'=> json_decode(get_setting('deal_of_the_day_links'), true)[$i],
                ];
            }
            return $deal_of_the_day;          
        });
    }
        $featured_categories = Cache::rememberForever('featured_categories', function () {
            for ($i=0; $i < DB::table('business_settings')->where('type','like','featured_category_mobile_banner_'.'%')->count() ; $i++) { 
                $featured_categories[$i] = [
                    'category_name'=> get_setting('featured_category_' . $i, null, ''),
                    'desktop_banner'=> uploaded_asset(get_setting('featured_category_desktop_banner_' . $i . '')) ,
                    'mobile_banner'=> uploaded_asset(get_setting('featured_category_mobile_banner_' . $i . '')),
                    'products_link'=> json_decode(get_setting('featured_category_' . $i . '_links', null, '')),
                ];
            }
           return $featured_categories;          
       });
      
        $slider_images = Cache::rememberForever('slider_images', function () {
            return json_decode(get_setting('home_banner1_images'), true);           
        });
    //   dd(compact('best_seller_category','recommended_on_sadar','deal_of_the_day','featured_categories','slider_images'));
        return view('frontend.index', compact('best_seller_category','recommended_on_sadar','deal_of_the_day','featured_categories','slider_images'));
    }

    public function login()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('frontend.user_login');
    }

    public function registration(Request $request)
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        if($request->has('referral_code') &&
                \App\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
                \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {

            try {
                $affiliate_validation_time = \App\AffiliateConfig::where('type', 'validation_time')->first();
                $cookie_minute = 30 * 24;
                if($affiliate_validation_time) {
                    $cookie_minute = $affiliate_validation_time->value * 60;
                }

                Cookie::queue('referral_code', $request->referral_code, $cookie_minute);
                $referred_by_user = User::where('referral_code', $request->product_referral_code)->first();

                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);
            } catch (\Exception $e) {

            }
        }
        return view('frontend.user_registration');
    }

    public function cart_login(Request $request)
    {
        $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->orWhere('phone', $request->email)->first();
        if($user != null){
            if(Hash::check($request->password, $user->password)){
                if($request->has('remember')){
                    auth()->login($user, true);
                }
                else{
                    auth()->login($user, false);
                }
            }
            else {
                flash(translate('Invalid email or password!'))->warning();
            }
        }
        return back();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if(Auth::user()->user_type == 'seller'){
			// return view('frontend.user.seller.dashboard');
			return redirect()->route('orders.index');
		  // return redirect()->route('orders.index');
        }
        elseif(Auth::user()->user_type == 'customer'){
			return view('frontend.user.customer.dashboard');
			//return redirect()->route('cart');
        }
        elseif(Auth::user()->user_type == 'delivery_boy'){
            return view('delivery_boys.frontend.dashboard');
        }
        else {
            abort(404);
        }
    }

    public function profile(Request $request)
    {
        if(Auth::user()->user_type == 'customer'){
            return view('frontend.user.customer.profile');
        }
        elseif(Auth::user()->user_type == 'delivery_boy'){
            return view('delivery_boys.frontend.profile');
        }
        elseif(Auth::user()->user_type == 'seller'){
            return view('frontend.user.seller.profile');
        }
    }

    public function customer_update_profile(Request $request)
    {
        if(env('DEMO_MODE') == 'On'){
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }
        $user->avatar_original = $request->photo;

        if($user->save()){
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }


    public function seller_update_profile(Request $request)
    {

        // dd("agya");
        if(env('DEMO_MODE') == 'On'){
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }
        $user->avatar_original = $request->photo;

       /*  $seller = $user->seller;
        $seller->cash_on_delivery_status = $request->cash_on_delivery_status;
        $seller->bank_payment_status = $request->bank_payment_status;
        $seller->bank_name = $request->bank_name;
        $seller->bank_acc_name = $request->bank_acc_name;
        $seller->bank_acc_no = $request->bank_acc_no;
        $seller->account_type = $request->account_type;
		$seller->ifsc_code = $request->ifsc_code;
		$seller->branch = $request->branch; */

        if($user->save()){
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

     public function flash_deal_details($slug)
    {
        $flash_deal = FlashDeal::where('slug', $slug)->first();
        if($flash_deal != null)
            return view('frontend.flash_deal_details', compact('flash_deal'));
        else {
            abort(404);
        }
    }

    public function load_featured_section(){
      
            $featured_products = Cache::remember('featured_products', 3600, function () {
                return filter_products(DB::table('products')
                ->where('featured', '1')
                )->select('products.id','products.slug','products.photos','products.name','products.rating','products.purchase_price','products.discount','products.unit_price','products.discount_type','products.holiday','products.discount_start_date','products.discount_end_date')->limit(10)->get();
                // return filter_products(Product::where('published', 1)->where('featured', '1'))->limit(10)->get();
            });

        return view('frontend.partials.featured_products_section',compact('featured_products'));
    }

    public function load_best_selling_section(){
        return view('frontend.partials.best_selling_section');
    }

    public function load_whats_new_products(){
        return view('frontend.partials.whats_new_section');
    }

    public function load_category_catalogue_products(Request $request){
        $lang = $request->lang;
        return view('frontend.partials.category_catalogue_products', compact('lang'));
    }

    public function load_auction_products_section(){
        if(!addon_is_activated('auction')){
            return;
        }
        return view('auction.frontend.auction_products_section');
    }

    public function load_home_categories_section(){
        return view('frontend.partials.home_categories_section');
    }

    public function load_best_sellers_section(){
        return view('frontend.partials.best_sellers_section');
    }

    public function trackOrder(Request $request)
    {
        if($request->has('order_code')){
            $order = Order::where('code', $request->order_code)->first();
            if($order != null){
                return view('frontend.track_order', compact('order'));
            }
        }
        return view('frontend.track_order');
    }

    public function product(Request $request, $slug)
    {
			$detailedProduct  = Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop')->where('slug', $slug)->where('approved', 1)->first();
			
        if($detailedProduct != null && $detailedProduct->published){
			if($detailedProduct->user->shop->holiday == 0){
				if($request->has('product_referral_code') &&
						\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
						\App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {

					$affiliate_validation_time = \App\AffiliateConfig::where('type', 'validation_time')->first();
					$cookie_minute = 30 * 24;
					if($affiliate_validation_time) {
						$cookie_minute = $affiliate_validation_time->value * 60;
					}
					Cookie::queue('product_referral_code', $request->product_referral_code, $cookie_minute);
					Cookie::queue('referred_product_id', $detailedProduct->id, $cookie_minute);

					$referred_by_user = User::where('referral_code', $request->product_referral_code)->first();

					$affiliateController = new AffiliateController;
					$affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);
				}
                if(auth()->user() != null) {
                    $user_id = Auth::user()->id;
                    if($request->session()->get('temp_user_id')) {
                        Cart::where('temp_user_id', $request->session()->get('temp_user_id'))
                                ->update(
                                        [
                                            'user_id' => $user_id,
                                            'temp_user_id' => null
                                        ]
                        );
        
                        Session::forget('temp_user_id');
                    }
                    $carts = Cart::where('user_id', $user_id)->get();
                } else {
                    $temp_user_id = $request->session()->get('temp_user_id');
                    if($temp_user_id == null){
                    $carts = [];
                    }
                    // $carts = Cart::where('temp_user_id', $temp_user_id)->get();
                    $carts = ($temp_user_id != null) ? Cart::where('temp_user_id', $temp_user_id)->get() : [] ;
                }
                $cartStatus = 0;
                foreach($carts as $item){
                if($item->product_id == $detailedProduct->id){
                                $cartStatus = 1;
                }
                }
				if($detailedProduct->digital == 1){
					return view('frontend.digital_product_details', compact('detailedProduct','carts','cartStatus'));
				}
				else {
					return view('frontend.product_details', compact('detailedProduct','carts','cartStatus'));
				}
			}
        }
        abort(404);
    }

    public function shop($slug)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if($shop!=null){
            $seller = Seller::where('user_id', $shop->user_id)->first();
            if ($seller->verification_status != 0){
                return view('frontend.seller_shop', compact('shop'));
            }
            else{
                return view('frontend.seller_shop_without_verification', compact('shop', 'seller'));
            }
        }
        abort(404);
    }

    public function filter_shop($slug, $type)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if($shop!=null && $type != null){
            return view('frontend.seller_shop', compact('shop', 'type'));
        }
        abort(404);
    }

    public function all_categories(Request $request)
    {
//        $categories = Category::where('level', 0)->orderBy('name', 'asc')->get();
        $categories = Category::where('level', 0)->orderBy('order_level', 'desc')->get();
        return view('frontend.all_category', compact('categories'));
    }
    public function all_brands(Request $request)
    {
        $categories = Category::all();
        return view('frontend.all_brand', compact('categories'));
    }

    public function show_product_upload_form(Request $request)
    {
        if(addon_is_activated('seller_subscription')){
            if(Auth::user()->seller->remaining_uploads > 0){
                $categories = Category::where('parent_id', 0)
                    ->where('digital', 0)
                    ->with('childrenCategories')
                    ->get();
                return view('frontend.user.seller.product_upload', compact('categories'));
            }
            else {
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                return back();
            }
        }
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('frontend.user.seller.product_upload', compact('categories'));
    }

    public function show_product_edit_form(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('frontend.user.seller.product_edit', compact('product', 'categories', 'tags', 'lang'));
    }

    public function seller_product_list(Request $request)
    {
        $search = null;
        $products = Product::where('user_id', Auth::user()->id)->where('digital', 0)->orderBy('created_at', 'desc');
        // $products = DB::table('products')->where('user_id', Auth::user()->id)->where('digital', 0)->orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $search = $request->search;
            $products = $products->where('name', 'like', '%'.$search.'%');
        }
        $products = $products->paginate(15);

        return view('frontend.user.seller.products', compact('products', 'search'));
    }

    public function home_settings(Request $request)
    {
        return view('home_settings.index');
    }

    public function top_10_settings(Request $request)
    {
        foreach (Category::all() as $key => $category) {
            if(is_array($request->top_categories) && in_array($category->id, $request->top_categories)){
                $category->top = 1;
                $category->save();
            }
            else{
                $category->top = 0;
                $category->save();
            }
        }

        foreach (Brand::all() as $key => $brand) {
            if(is_array($request->top_brands) && in_array($brand->id, $request->top_brands)){
                $brand->top = 1;
                $brand->save();
            }
            else{
                $brand->top = 0;
                $brand->save();
            }
        }

        flash(translate('Top 10 categories and brands have been updated successfully'))->success();
        return redirect()->route('home_settings.index');
    }

    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;
        $tax = 0; 
        $max_limit = 0;
        $price = $product->price;

        if($request->has('color')){
            $str = $request['color'];
        }
        //   if($request->has('product_id')){
        //     $str = $request['product_id'];
        // }

        if(json_decode($product->choice_options) != null){
            foreach (json_decode($product->choice_options) as $key => $choice) {
                if($str != null){
                    $str .= '-'.str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
                else{
                    $str .= str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
            }
        }

         $product_stock = $product->stocks->where('variant', $str)->first();
        //$product_stock = $product->stocks->where('product_id', $str)->first();
        $price = $product_stock->price;
        $quantity = $product_stock->qty;
        $max_limit = $product_stock->qty;
//        if($str != null && $product->variant_product){
//        }
//        else{
//            $price = $product->unit_price;
//            $quantity = $product->current_stock;
//        }

        if($quantity >= 1 && $product->min_qty <= $quantity){
            $in_stock = 1;
        }else{
            $in_stock = 0;
        }

        //Product Stock Visibility
        if($product->stock_visibility_state == 'text') {
            if($quantity >= 1 && $product->min_qty < $quantity){
                $quantity = translate('In Stock');
            }else{
                $quantity = translate('Out Of Stock');
            }
        }

        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        }
        elseif (strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        // taxes
        foreach ($product->taxes as $product_tax) {
            if($product_tax->tax_type == 'percent'){
                $tax += ($price * $product_tax->tax) / 100;
            }
            elseif($product_tax->tax_type == 'amount'){
                $tax += $product_tax->tax;
            }
        }

        $price += 0;

        return array(
            'price' => single_price($price*$request->quantity),
            'quantity' => $quantity,
            'digital' => $product->digital,
            'variation' => $str,
            'max_limit' => $max_limit,
            'in_stock' => $in_stock
        );
    }

    public function sellerpolicy(){
        return view("frontend.policies.sellerpolicy");
    }

    public function returnpolicy(){
        return view("frontend.policies.returnpolicy");
    }

    public function supportpolicy(){
        return view("frontend.policies.supportpolicy");
    }

    public function terms(){
        return view("frontend.policies.terms");
    }

    public function privacypolicy(){
        return view("frontend.policies.privacypolicy");
    }

    public function get_pick_up_points(Request $request)
    {
        $pick_up_points = PickupPoint::all();
        return view('frontend.partials.pick_up_points', compact('pick_up_points'));
    }

    public function get_category_items(Request $request){
        $category = Category::findOrFail($request->id);
        return view('frontend.partials.category_elements', compact('category'));
    }

    public function premium_package_index()
    {
        $customer_packages = CustomerPackage::all();
        return view('frontend.user.customer_packages_lists', compact('customer_packages'));
    }

    public function seller_digital_product_list(Request $request)
    {
        $products = Product::where('user_id', Auth::user()->id)->where('digital', 1)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.user.seller.digitalproducts.products', compact('products'));
    }
    public function show_digital_product_upload_form(Request $request)
    {
        if(addon_is_activated('seller_subscription')){
            if(Auth::user()->seller->remaining_digital_uploads > 0){
                $business_settings = BusinessSetting::where('type', 'digital_product_upload')->first();
                $categories = Category::where('digital', 1)->get();
                return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
            }
            else {
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                return back();
            }
        }

        $business_settings = BusinessSetting::where('type', 'digital_product_upload')->first();
        $categories = Category::where('digital', 1)->get();
        return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
    }

    public function show_digital_product_edit_form(Request $request, $id)
    {
        $categories = Category::where('digital', 1)->get();
        $lang = $request->lang;
        $product = Product::find($id);
        return view('frontend.user.seller.digitalproducts.product_edit', compact('categories', 'product', 'lang'));
    }

    // Ajax call
    public function new_verify(Request $request)
    {
        $email = $request->email;
        if(isUnique($email) == '0') {
            $response['status'] = 2;
            $response['message'] = 'Email already exists!';
            return json_encode($response);
        }

        $response = $this->send_email_change_verification_mail($request, $email);
        return json_encode($response);
    }


    // Form request
    public function update_email(Request $request)
    {
        $email = $request->email;
        if(isUnique($email)) {
            $this->send_email_change_verification_mail($request, $email);
            flash(translate('A verification mail has been sent to the mail you provided us with.'))->success();
            return back();
        }

        flash(translate('Email already exists!'))->warning();
        return back();
    }

    public function send_email_change_verification_mail($request, $email)
    {
        $response['status'] = 0;
        $response['message'] = 'Unknown';

        $verification_code = Str::random(32);

        $array['subject'] = 'Email Verification';
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = 'Verify your account';
        $array['link'] = route('email_change.callback').'?new_email_verificiation_code='.$verification_code.'&email='.$email;
        $array['sender'] = Auth::user()->name;
        $array['details'] = "Email Second";

        $user = Auth::user();
        $user->new_email_verificiation_code = $verification_code;
        $user->save();

        try {
            Mail::to($email)->queue(new SecondEmailVerifyMailManager($array));

            $response['status'] = 1;
            $response['message'] = translate("Your verification mail has been Sent to your email.");

        } catch (\Exception $e) {
            // return $e->getMessage();
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function email_change_callback(Request $request){
        if($request->has('new_email_verificiation_code') && $request->has('email')) {
            $verification_code_of_url_param =  $request->input('new_email_verificiation_code');
            $user = User::where('new_email_verificiation_code', $verification_code_of_url_param)->first();

            if($user != null) {

                $user->email = $request->input('email');
                $user->new_email_verificiation_code = null;
                $user->save();

                auth()->login($user, true);

                flash(translate('Email Changed successfully'))->success();
                return redirect()->route('dashboard');
            }
        }

        flash(translate('Email was not verified. Please resend your mail!'))->error();
        return redirect()->route('dashboard');

    }

    public function reset_password_with_code(Request $request){
        if (($user = User::where('email', $request->email)->where('verification_code', $request->code)->first()) != null) {
            if($request->password == $request->password_confirmation){
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();
                event(new PasswordReset($user));
                auth()->login($user, true);

                flash(translate('Password updated successfully'))->success();

                if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff')
                {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('home');
            }
            else {
                flash("Password and confirm password didn't match")->warning();
                return redirect()->route('password.request');
            }
        }
        else {
            flash("Verification code mismatch")->error();
            return redirect()->route('password.request');
        }
    }


    public function all_flash_deals() {
        $today = strtotime(date('Y-m-d H:i:s'));

        $data['all_flash_deals'] = FlashDeal::where('status', 1)
                ->where('start_date', "<=", $today)
                ->where('end_date', ">", $today)
                ->orderBy('created_at', 'desc')
                ->get();

        return view("frontend.flash_deal.all_flash_deal_list", $data);
    }

    public function all_seller(Request $request) {
        $shops = Shop::whereIn('user_id', verified_sellers_id())
                ->paginate(15);

        return view('frontend.shop_listing', compact('shops'));
    }

    public function all_coupons(Request $request) {
        $coupons = Coupon::where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->paginate(15);
        return view('frontend.coupons', compact('coupons'));
    }

    public function inhouse_products(Request $request) {
        $products = filter_products(Product::where('added_by', 'admin'))->with('taxes')->paginate(12)->appends(request()->query());
        return view('frontend.inhouse_products', compact('products'));
    }
	
	public function otplogin()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('frontend.mobile_login');
    }
	
	public function mobilelogin(Request $request)
    {
        // Check validation
        // $this->validate($request, [
        //     'phone' => 'required|regex:/[0-9]{10}/|digits:10',            
        // ]);
		$phone = $request->get('email_phone');
		
        // Get user record
        $user = User::where('phone', $request->get('email_phone'))
        ->orWhere('email',$request->get('email_phone'))->first();
		// dd($user);
        // Check Condition Mobile No. Found or Not
		if($user == null) {
			flash(translate('Your mobile number or email not match in our system..!!'))->error();
			return back();
		} else{
			if($phone != $user->phone && $phone != $user->email) {
				flash(translate('Your mobile number or email not match in our system..!!'))->error();
				return back();
			}
		}
		
        $otp = rand(100000, 999999);
        $email = $user->email;
        $phone = $user->phone;
		$api = 'c59e9994-ef4f-11ea-9fa5-0200cd936042';
		$url = "https://2factor.in/API/V1/".$api."/SMS/+91".$phone."/".$otp."/smsotp1";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		$resp1 = json_decode($resp, true);
		$status =  $resp1['Status'];
		$session_id =  $resp1['Details'];
        if($user->phone == null){
            $phone = $user->email;
        }
        $user->verification_code = $otp;
        $user->save();
        Notification::route('mail', $user->email)->notify(new EmailLoginNotification($otp));
        // Set Auth Details
		if ($user->phone == null || $status == "Success"){
			flash(translate('OTP is sent on '.$request->get('email_phone').'.'))->success();
			return view('frontend.otp', compact('resp','session_id','phone'));
		} else{
			
			flash(translate($status.'! OTP is wrong..!!'))->error();
			
            return back();
			
		}
        
		//var_dump($resp);
        
        // Set Auth Details
        //\Auth::login($user);
        
        // Redirect home page
        //return redirect()->route('home');
		
    }
	
	public function otp(Request $request)
    {
        // $this->validate($request, [
        //     'phone' => 'required|regex:/[0-9]{10}/|digits:10',            
        // ]);

        // Get user record
        $user = User::where('phone', $request->get('phone'))
        ->orWhere('email',$request->get('phone'))->first();
		$otp = $request->get('otp');
        
		$session_id =  $request->get('session_id');
		$api = 'c59e9994-ef4f-11ea-9fa5-0200cd936042';
		$url = "https://2factor.in/API/V1/".$api."/SMS/VERIFY/".$session_id."/".$otp;
		
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		
		curl_close($curl);
		$resp1 = json_decode($resp, true);
		
        $status =  $resp1['Status'];
        

        // Set Auth Details
        if($user->verification_code == $otp || $status == "Success"){
			\Auth::login($user);
			if($user->user_type == 'seller'){
				flash(translate('Login successfully'))->success();
				return redirect()->route('orders.index');
			}
			elseif($user->user_type == 'customer'){
				flash(translate('Login successfully'))->success();
				return redirect()->route('cart');
			}
			// Redirect home page
			flash(translate('Login successfully'))->success();
			return redirect()->route('cart');
		} else{
			flash(translate($status.'! OTP is wrong..!!'))->error();
			
            return redirect()->route('user.otplogin');
			
		}
        
        
    }
	public function guestRegistration(Request $request)
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        if($request->has('referral_code') &&
                \App\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
                \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {

            try {
                $affiliate_validation_time = \App\AffiliateConfig::where('type', 'validation_time')->first();
                $cookie_minute = 30 * 24;
                if($affiliate_validation_time) {
                    $cookie_minute = $affiliate_validation_time->value * 60;
                }

                Cookie::queue('referral_code', $request->referral_code, $cookie_minute);
                $referred_by_user = User::where('referral_code', $request->product_referral_code)->first();

                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);
            } catch (\Exception $e) {

            }
        }
        return view('frontend.user_guest_registration');
    }
	public function guestRegister(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
        }
        else{ 
            $user = User::where('phone', '+'.$request->country_code.$request->phone)->first();
        }
        if($user == null){
                $user = User::create([

                'name' => $request->name, 

                'email' =>  $request->email, 

                'password' => encrypt('Sadarmarket@24')

            ]);    
        }
		 if($user->email != null){
			$user->email_verified_at = date('Y-m-d H:m:s');
			$user->save();
			flash(translate('Guest Login successful.'))->success();
			\Auth::login($user);
			return redirect()->route('cart');
            
        }
		
		return back();
        
    }
    public function checkoutGuestRegister(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
        }
        else{ 
            $user = User::where('phone', '+'.$request->country_code.$request->phone)->first();
        }
        if($user == null){
                $user = User::create([

                'name' => $request->name, 

                'email' =>  $request->email, 

                'password' => encrypt('Sadarmarket@24')

            ]);    
        }
		 if($user->email != null){
			$user->email_verified_at = date('Y-m-d H:m:s');
			$user->save();
			flash(translate('Guest Login successful.'))->success();
			\Auth::login($user);
            $status = 1;
            // dd($user);
            if(auth()->user() != null) {
                $user_id = Auth::user()->id;
                if($request->session()->get('temp_user_id')) {
                    Cart::where('temp_user_id', $request->session()->get('temp_user_id'))
                            ->update(
                                    [
                                        'user_id' => $user_id,
                                        'temp_user_id' => null
                                    ]
                    );
    
                    Session::forget('temp_user_id');
                }
                $carts = Cart::where('user_id', $user_id)->get();
            } else {
                $temp_user_id = $request->session()->get('temp_user_id');
                if($temp_user_id == null){
                return redirect()->route('home');
                }
                // $carts = Cart::where('temp_user_id', $temp_user_id)->get();
                $carts = ($temp_user_id != null) ? Cart::where('temp_user_id', $temp_user_id)->get() : [] ;
            }
            // $carts = Cart::where('user_id', $user->id)->get();
            // dd($carts);
            $summary = view('frontend.partials.cart_summary',compact('carts'))->render();
            $shipping_address = view('frontend.partials.shippingAddress')->render();
            $nav_cart_view = view('frontend.partials.cart',compact('carts'))->render();
            $cart_count = count($carts);
			return compact('summary','shipping_address','nav_cart_view','cart_count');
            
        }
		
		return back();
		        
    }

    public function checkPincodeAvailability(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Token 13e6e16ea6506989bb0d3fbaef437402278bffeb',
        ])->get('https://track.delhivery.com/c/api/pin-codes/json/?token=13e6e16ea6506989bb0d3fbaef437402278bffeb&filter_codes='.$request->pincode.'');
        // dump($response->json());
        // dd($response->json('delivery_codes')[0]['postal_code']);
        // $pincodeDetails = DB::table('pincode_delhivery')->where('pincode', '=', $request->pincode)->first();
        // $exists = DB::table('pincode_delhivery')->where('pincode', '=', $request->pincode)->exists();
        if(count($response->json('delivery_codes')) == 1){
        return response()->json([
            'exists' => count($response->json('delivery_codes')),
            'response' => $response->json('delivery_codes')[0]['postal_code'],
        ]);
    }
    else{
        return response()->json([
            'exists' => 0,
            'response' => [],
        ]);
    }
    }

    // new bulk product system controller functions.
    // new bulk product system controller functions.

    public function pilot_product(Request $request, $slug)
    {
		// $detailedProduct  = Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop')->where('slug', $slug)->where('approved', 1)->first();
			
        $detailedProduct = DB::table('pilot_product')->where([['slug',$slug]])
        ->first();
      
        if($detailedProduct != null){
            $detailedProduct->variant_product = DB::table('product_attributes')->where('product_id',$detailedProduct->id)->get();
            // dd($detailedProduct);
		// 	if($detailedProduct->user->shop->holiday == 0){
		// 		if($request->has('product_referral_code') &&
		// 				\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
		// 				\App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {

		// 			$affiliate_validation_time = \App\AffiliateConfig::where('type', 'validation_time')->first();
		// 			$cookie_minute = 30 * 24;
		// 			if($affiliate_validation_time) {
		// 				$cookie_minute = $affiliate_validation_time->value * 60;
		// 			}
		// 			Cookie::queue('product_referral_code', $request->product_referral_code, $cookie_minute);
		// 			Cookie::queue('referred_product_id', $detailedProduct->id, $cookie_minute);

		// 			$referred_by_user = User::where('referral_code', $request->product_referral_code)->first();

		// 			$affiliateController = new AffiliateController;
		// 			$affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);
		// 		}
                if(auth()->user() != null) {
                    $user_id = Auth::user()->id;
                    if($request->session()->get('temp_user_id')) {
                        Cart::where('temp_user_id', $request->session()->get('temp_user_id'))
                                ->update(
                                        [
                                            'user_id' => $user_id,
                                            'temp_user_id' => null
                                        ]
                        );
        
                        Session::forget('temp_user_id');
                    }
                    $carts = Cart::where('user_id', $user_id)->get();
                } else {
                    $temp_user_id = $request->session()->get('temp_user_id');
                    if($temp_user_id == null){
                    $carts = [];
                    }
                    // $carts = Cart::where('temp_user_id', $temp_user_id)->get();
                    $carts = ($temp_user_id != null) ? Cart::where('temp_user_id', $temp_user_id)->get() : [] ;
                }
                $cartStatus = 0;
                foreach($carts as $item){
                if($item->product_id == $detailedProduct->id){
                                $cartStatus = 1;
                }
                }
		// 		if($detailedProduct->digital == 1){
		// 			return view('frontend.digital_product_details', compact('detailedProduct','carts','cartStatus'));
		// 		}
		// 		else {
					// return view('frontend.product_details', compact('detailedProduct','carts','cartStatus'));
		// 		}
					return view('frontend.pilot_product_details', compact('detailedProduct','carts','cartStatus'));

		// 	}
       
}
        // abort(404);
    }
}
