<?php

namespace App\Http\Controllers;

use Auth;
use Cache;
use Artisan;
use App\Cart;
use App\Shop;
use App\Product;
use App\Category;
use Combinations;
use Carbon\Carbon;
use App\ProductTax;
use App\ProductStock;
use App\AttributeValue;
use App\FlashDealProduct;
use App\ProductTranslation;
use Illuminate\Support\Str;
use CoreComponentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_products(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $type = 'In House';
        $col_name = null;
        $query = null;
        $sort_search = null;

        $products = Product::where('added_by', 'admin')->where('auction_product',0);

        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }
        if ($request->search != null){
            $products = $products
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $products = $products->where('digital', 0)->orderBy('created_at', 'desc')->paginate(15);

        return view('backend.product.products.index', compact('products','type', 'col_name', 'query', 'sort_search'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seller_products(Request $request)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $products = Product::where('added_by', 'seller')->where('auction_product',0);
        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null){
            $products = $products
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }
        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $products = $products->where('digital', 0)->orderBy('created_at', 'desc')->paginate(15);
        $type = 'Seller';

        return view('backend.product.products.index', compact('products','type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }
	public function productfil(){
		$col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $products = Product::where('added_by', 'seller')->where('auction_product',0);
        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null){
            $products = $products
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }
        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $products = $products->where('digital', 0)->orderBy('created_at', 'desc')->paginate(15);
        $type = 'Seller';

        return view('backend.product.products.index', compact('products','type', 'col_name', 'query', 'seller_id', 'sort_search'));
	}
	
	
    public function all_products(Request $request)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $products = Product::orderBy('created_at', 'desc')->where('auction_product',0);
        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null){
            $products = $products
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }
        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $products = $products->paginate(15);
        $type = 'All';

        return view('backend.product.products.index', compact('products','type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CoreComponentRepository::initializeCache();

        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        return view('backend.product.products.create', compact('categories'));
    }

    public function add_more_choice_option(Request $request) {
        $all_attribute_values = AttributeValue::with('attribute')->where('attribute_id', $request->attribute_id)->get();

        $html = '';

        foreach ($all_attribute_values as $row) {
            $html .= '<option value="' . $row->value . '">' . $row->value . '</option>';
        }

        echo json_encode($html);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();

        $product = new Product;
        $product->name = $request->name;
        $product->added_by = $request->added_by;
        if(Auth::user()->user_type == 'seller'){
            $product->user_id = Auth::user()->id;
            if(get_setting('product_approve_by_admin') == 1) {
                $product->approved = 0;
            }
        }
        else{
            $product->user_id = \App\User::where('user_type', 'admin')->first()->id;
        }
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->barcode = $request->barcode;

        if ($refund_request_addon != null && $refund_request_addon->activated == 1) {
            if ($request->refundable != null) {
                $product->refundable = 1;
            }
            else {
                $product->refundable = 0;
            }
        }
        $product->photos = $request->photos;
        $product->thumbnail_img = $request->thumbnail_img;
        $product->unit = $request->unit;
        $product->min_qty = $request->min_qty;
        $product->max_qty = $request->max_qty;
        $product->low_stock_quantity = $request->low_stock_quantity;
        $product->stock_visibility_state = $request->stock_visibility_state;
        $product->external_link = $request->external_link;

        $tags = array();
        if($request->tags[0] != null){
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags = implode(',', $tags);

        $product->description = $request->description;
		$product->specification = $request->specification;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;

        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $product->discount_start_date = strtotime($date_var[0]);
            $product->discount_end_date   = strtotime( $date_var[1]);
        }

        $product->shipping_type = $request->shipping_type;
        $product->est_shipping_days  = $request->est_shipping_days;

        if (\App\Addon::where('unique_identifier', 'club_point')->first() != null &&
                \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
            if($request->earn_point) {
                $product->earn_point = $request->earn_point;
            }
        }

        if ($request->has('shipping_type')) {
            if($request->shipping_type == 'free'){
                $product->shipping_cost = 0;
            }
            elseif ($request->shipping_type == 'flat_rate') {
                $product->shipping_cost = $request->flat_shipping_cost;
            }
            elseif ($request->shipping_type == 'product_wise') {
                $product->shipping_cost = json_encode($request->shipping_cost);
            }
        }
        if ($request->has('is_quantity_multiplied')) {
            $product->is_quantity_multiplied = 1;
        }

        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

        if($request->has('meta_img')){
            $product->meta_img = $request->meta_img;
        } else {
            $product->meta_img = $product->thumbnail_img;
        }

        if($product->meta_title == null) {
            $product->meta_title = $product->name;
        }

        if($product->meta_description == null) {
            $product->meta_description = strip_tags($product->description);
        }

        if($product->meta_img == null) {
            $product->meta_img = $product->thumbnail_img;
        }

        if($request->hasFile('pdf')){
            $product->pdf = $request->pdf->store('uploads/products/pdf');
        }

        $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->name)));

        if(Product::where('slug', $product->slug)->count() > 0){
            flash(translate('Another product exists with same slug. Please change the slug!'))->warning();
            return back();
        }

        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $product->colors = json_encode($request->colors);
        }
        else {
            $colors = array();
            $product->colors = json_encode($colors);
        }

        $choice_options = array();

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_'.$no;

                $item['attribute_id'] = $no;

                $data = array();
                // foreach (json_decode($request[$str][0]) as $key => $eachValue) {
                foreach ($request[$str] as $key => $eachValue) {
                    // array_push($data, $eachValue->value);
                    array_push($data, $eachValue);
                }

                $item['values'] = $data;
                array_push($choice_options, $item);
            }
        }

        if (!empty($request->choice_no)) {
            $product->attributes = json_encode($request->choice_no);
        }
        else {
            $product->attributes = json_encode(array());
        }

        $product->choice_options = json_encode($choice_options, JSON_UNESCAPED_UNICODE);

        $product->published = 0;
        if($request->button == 'unpublish' || $request->button == 'draft') {
            $product->published = 0;
        }

        if ($request->has('cash_on_delivery')) {
            $product->cash_on_delivery = 1;
        }
        if ($request->has('featured')) {
            $product->featured = 0;
        }
        if ($request->has('todays_deal')) {
            $product->todays_deal = 0;
        }
        $product->cash_on_delivery = 0;
        if ($request->cash_on_delivery) {
            $product->cash_on_delivery = 1;
        }
        //$variations = array();
        $product->created_at = time();
        $product->updated_at = time();
        $product->save();

        //VAT & Tax
        if($request->tax_id) {
            foreach ($request->tax_id as $key => $val) {
                $product_tax = new ProductTax;
                $product_tax->tax_id = $val;
                $product_tax->product_id = $product->id;
                $product_tax->tax = $request->tax[$key];
                $product_tax->tax_type = $request->tax_type[$key];
                $product_tax->save();
            }
        }
        //Flash Deal
        if($request->flash_deal_id) {
            $flash_deal_product = new FlashDealProduct;
            $flash_deal_product->flash_deal_id = $request->flash_deal_id;
            $flash_deal_product->product_id = $product->id;
            $flash_deal_product->save();
        }

        //combinations start
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        }

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $data = array();
                foreach ($request[$name] as $key => $eachValue) {
                    array_push($data, $eachValue);
                }
                array_push($options, $data);
            }
        }

        //Generates the combinations of customer choice options
        $combinations = Combinations::makeCombinations($options);
        if(count($combinations[0]) > 0){
            $product->variant_product = 1;
            foreach ($combinations as $key => $combination){
                $str = '';
                foreach ($combination as $key => $item){
                    if($key > 0 ){
                        $str .= '-'.str_replace(' ', '', $item);
                    }
                    else{
                        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
                            $color_name = \App\Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        }
                        else{
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }
                $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $str)->first();
                if($product_stock == null){
                    $product_stock = new ProductStock;
                    $product_stock->product_id = $product->id;
                }

                $product_stock->variant = $str;
                $product_stock->price = $request['price_'.str_replace('.', '_', $str)];
                $product_stock->sku = $request['sku_'.str_replace('.', '_', $str)];
                $product_stock->qty = $request['qty_'.str_replace('.', '_', $str)];
                $product_stock->image = $request['img_'.str_replace('.', '_', $str)];
                $product_stock->save();
            }
        }
        else{
            $product_stock              = new ProductStock;
            $product_stock->product_id  = $product->id;
            $product_stock->variant     = '';
            $product_stock->price       = $request->unit_price;
            $product_stock->sku         = $request->sku;
            $product_stock->qty         = $request->current_stock;
            $product_stock->save();
        }
        //combinations end

	    $product->save();

        // Product Translations
        $product_translation = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $product->id]);
        $product_translation->name = $request->name;
        $product_translation->unit = $request->unit;
        $product_translation->description = $request->description;
		$product_translation->specification = $request->specification;
        $product_translation->save();

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff'){
            return redirect()->route('products.admin');
        }
        else{
            if(addon_is_activated('seller_subscription')){
                $seller = Auth::user()->seller;
                $seller->remaining_uploads -= 1;
                $seller->save();
            }
            return redirect()->route('seller.products');
        }
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
     public function admin_product_edit(Request $request, $id)
     {
        CoreComponentRepository::initializeCache();

        $product = Product::findOrFail($id);
        if($product->digital == 1) {
            return redirect('digitalproducts/' . $id . '/edit');
        }

        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('backend.product.products.edit', compact('product', 'categories', 'tags','lang'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function seller_product_edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if($product->digital == 1) {
            return redirect('digitalproducts/' . $id . '/edit');
        }
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::all();
        return view('backend.product.products.edit', compact('product', 'categories', 'tags','lang'));
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
        $refund_request_addon       = \App\Addon::where('unique_identifier', 'refund_request')->first();
        $product                    = Product::findOrFail($id);
        $product->category_id       = $request->category_id;
        $product->brand_id          = $request->brand_id;
        $product->barcode           = $request->barcode;
        $product->cash_on_delivery = 0;
        $product->featured = 0;
        $product->todays_deal = 0;
        $product->is_quantity_multiplied = 0;

        if ($refund_request_addon != null && $refund_request_addon->activated == 1) {
            if ($request->refundable != null) {
                $product->refundable = 1;
            }
            else {
                $product->refundable = 0;
            }
        }
		//$product->lang = env('DEFAULT_LANGUAGE');
        if($request->lang == env("DEFAULT_LANGUAGE")){
            $product->name          = $request->name;
            $product->unit          = $request->unit;
            $product->specification = $request->specification;
			$product->description   = $request->description;
            $product->slug          = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->slug)));
        }

        if($request->slug == null){
            $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->name)));
        }

        if(Product::where('id', '!=', $product->id)->where('slug', $product->slug)->count() > 0){
            flash(translate('Another product exists with same slug. Please change the slug!'))->warning();
            return back();
        }

        $product->photos                 = $request->photos;
        $product->thumbnail_img          = $request->thumbnail_img;
        $product->min_qty                = $request->min_qty;
        $product->max_qty                = $request->max_qty;
        $product->low_stock_quantity     = $request->low_stock_quantity;
        $product->stock_visibility_state = $request->stock_visibility_state;
        $product->external_link = $request->external_link;

        $tags = array();
        if($request->tags[0] != null){
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags           = implode(',', $tags);

        $product->video_provider = $request->video_provider;
        $product->video_link     = $request->video_link;
        $product->unit_price     = $request->unit_price;
        $product->discount       = $request->discount;
        $product->discount_type     = $request->discount_type;

        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $product->discount_start_date = strtotime($date_var[0]);
            $product->discount_end_date   = strtotime( $date_var[1]);
        }

        $product->shipping_type  = $request->shipping_type;
        $product->est_shipping_days  = $request->est_shipping_days;

        if (\App\Addon::where('unique_identifier', 'club_point')->first() != null &&
                \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
            if($request->earn_point) {
                $product->earn_point = $request->earn_point;
            }
        }

        if ($request->has('shipping_type')) {
            if($request->shipping_type == 'free'){
                $product->shipping_cost = 0;
            }
            elseif ($request->shipping_type == 'flat_rate') {
                $product->shipping_cost = $request->flat_shipping_cost;
            }
            elseif ($request->shipping_type == 'product_wise') {
                $product->shipping_cost = json_encode($request->shipping_cost);
            }
        }

        if ($request->has('is_quantity_multiplied')) {
            $product->is_quantity_multiplied = 1;
        }
        if ($request->has('cash_on_delivery')) {
            $product->cash_on_delivery = 1;
        }

        if ($request->has('featured')) {
            $product->featured = 0;
        }

        if ($request->has('todays_deal')) {
            $product->todays_deal = 0;
        }

        $product->meta_title        = $request->meta_title;
        $product->meta_description  = $request->meta_description;
        $product->meta_img          = $request->meta_img;

        if($product->meta_title == null) {
            $product->meta_title = $product->name;
        }

        if($product->meta_description == null) {
            $product->meta_description = strip_tags($product->description);
        }

        if($product->meta_img == null) {
            $product->meta_img = $product->thumbnail_img;
        }

        //$product->pdf = $request->pdf;

        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $product->colors = json_encode($request->colors);
        }
        else {
            $colors = array();
            $product->colors = json_encode($colors);
        }

        $choice_options = array();

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_'.$no;

                $item['attribute_id'] = $no;

                $data = array();
                foreach ($request[$str] as $key => $eachValue) {
                    array_push($data, $eachValue);
                }

                $item['values'] = $data;
                array_push($choice_options, $item);
            }
        }

        foreach ($product->stocks as $key => $stock) {
            $stock->delete();
        }

        if (!empty($request->choice_no)) {
            $product->attributes = json_encode($request->choice_no);
        }
        else {
            $product->attributes = json_encode(array());
        }

        $product->choice_options = json_encode($choice_options, JSON_UNESCAPED_UNICODE);


        //combinations start
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $data = array();
                foreach ($request[$name] as $key => $item) {
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = Combinations::makeCombinations($options);
        if(count($combinations[0]) > 0){
            $product->variant_product = 1;
            foreach ($combinations as $key => $combination){
                $str = '';
                foreach ($combination as $key => $item){
                    if($key > 0 ){
                        $str .= '-'.str_replace(' ', '', $item);
                    }
                    else{
                        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
                            $color_name = \App\Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        }
                        else{
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }

                $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $str)->first();
                if($product_stock == null){
                    $product_stock = new ProductStock;
                    $product_stock->product_id = $product->id;
                }
                if(isset($request['price_'.str_replace('.', '_', $str)])) {

                    $product_stock->variant = $str;
                    $product_stock->price = $request['price_'.str_replace('.', '_', $str)];
                    $product_stock->sku = $request['sku_'.str_replace('.', '_', $str)];
                    $product_stock->qty = $request['qty_'.str_replace('.', '_', $str)];
                    $product_stock->image = $request['img_'.str_replace('.', '_', $str)];

                    $product_stock->save();
                }
            }
        }
        else{
            $product_stock              = new ProductStock;
            $product_stock->product_id  = $product->id;
            $product_stock->variant     = '';
            $product_stock->price       = $request->unit_price;
            $product_stock->sku         = $request->sku;
            $product_stock->qty         = $request->current_stock;
            $product_stock->save();
        }

        $product->save();

        //Flash Deal
        if($request->flash_deal_id) {
            if($product->flash_deal_product){
                $flash_deal_product = FlashDealProduct::findOrFail($product->flash_deal_product->id);
                if(!$flash_deal_product) {
                    $flash_deal_product = new FlashDealProduct;
                }
            } else {
                $flash_deal_product = new FlashDealProduct;
            }

            $flash_deal_product->flash_deal_id = $request->flash_deal_id;
            $flash_deal_product->product_id = $product->id;
            $flash_deal_product->discount = $request->flash_discount;
            $flash_deal_product->discount_type = $request->flash_discount_type;
            $flash_deal_product->save();
//            dd($flash_deal_product);
        }

        //VAT & Tax
        if($request->tax_id) {
            ProductTax::where('product_id', $product->id)->delete();
            foreach ($request->tax_id as $key => $val) {
                $product_tax = new ProductTax;
                $product_tax->tax_id = $val;
                $product_tax->product_id = $product->id;
                $product_tax->tax = $request->tax[$key];
                $product_tax->tax_type = $request->tax_type[$key];
                $product_tax->save();
            }
        }
		$specifi = " ";
		if(!$request->specification){
			
		}
		else{
			$specifi = $request->specification;
		}
        // Product Translations
        $product_translation                = ProductTranslation::firstOrNew(['lang' => $request->lang, 'product_id' => $product->id]);
		$product_translation->lang			= env("DEFAULT_LANGUAGE");
        $product_translation->name          = $request->name;
        $product_translation->unit          = $request->unit;
        $product_translation->description   = $request->description;
		$product_translation->specification   = $specifi;
        $product_translation->save();

        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

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
        $product = Product::findOrFail($id);
        foreach ($product->product_translations as $key => $product_translations) {
            $product_translations->delete();
        }

        foreach ($product->stocks as $key => $stock) {
            $stock->delete();
        }

        if(Product::destroy($id)){
            Cart::where('product_id', $id)->delete();

            flash(translate('Product has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            return back();
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_product_delete(Request $request) {
        if($request->id) {
            foreach ($request->id as $product_id) {
                $this->destroy($product_id);
            }
        }

        return 1;
    }

    /**
     * Duplicates the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Request $request, $id)
    {   
        if(isset($request->id)){
        $product = Product::find($request->id);
        }
        else{
            $product = Product::find($id);
        }

        if(Auth::user()->id == $product->user_id || Auth::user()->user_type == 'staff' || Auth::user()->user_type == 'admin'){
            $product_new = $product->replicate();
            $product_new->slug = $product_new->slug.'-'.Str::random(5);
            $product_new->save();

            foreach ($product->stocks as $key => $stock) {
                $product_stock              = new ProductStock;
                $product_stock->product_id  = $product_new->id;
                $product_stock->variant     = $stock->variant;
                $product_stock->price       = $stock->price;
                $product_stock->sku         = $stock->sku;
                $product_stock->qty         = $stock->qty;
                $product_stock->save();

            }   
            flash(translate('Product has been duplicated successfully'))->success();
            if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff'){
                if($request->type == 'In House')
                return redirect()->route('products.admin');
              elseif($request->type == 'Seller')
                return redirect()->route('products.seller');
              elseif($request->type == 'All')
                return redirect()->route('products.all');
              elseif(Auth::user()->user_type == 'admin')
              return redirect()->back();
            }
            else{
                if (addon_is_activated('seller_subscription')) {
                    $seller = Auth::user()->seller;
                    $seller->remaining_uploads -= 1;
                    $seller->save();
                }
                return redirect()->route('seller.products');
            }
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function get_products_by_brand(Request $request)
    {
        $products = Product::where('brand_id', $request->brand_id)->get();
        return view('partials.product_select', compact('products'));
    }

    public function updateTodaysDeal(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->todays_deal = $request->status;
        $product->save();
        Cache::forget('todays_deal_products');
        return 1;
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;

        if($product->added_by == 'seller' && addon_is_activated('seller_subscription')){
            $seller = $product->user->seller;
            if($seller->invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0){
                return 0;
            }
        }

        $product->save();
        return 1;
    }
	
	public function updateSellerOnVacation(Request $request)
    {
		$holiday = $request->status;
		// Shop::where('user_id', $request->id)->update(array('holiday' => $holiday));
		Shop::where('user_id', '=', $request->id)->update([
            'holiday' => $holiday
        ]);
        Product::where('user_id', '=', $request->id)->update([
            'holiday' => $holiday
        ]);
        /* $product = Product::findOrFail($request->id);
        $product->published = $request->status;

        if($product->added_by == 'seller' && addon_is_activated('seller_subscription')){
            $seller = $product->user->seller;
            if($seller->invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0){
                return 0;
            }
        }

        $product->save(); */
        return 1;
    }

    public function updateProductApproval(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->approved = $request->approved;

        if($product->added_by == 'seller' && addon_is_activated('seller_subscription')){
            $seller = $product->user->seller;
            if($seller->invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0){
                return 0;
            }
        }

        $product->save();
        return 1;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->status;
        if($product->save()){
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            return 1;
        }
        return 0;
    }

    public function updateSellerFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->seller_featured = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function sku_combination(Request $request)
    {
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $data = array();
                // foreach (json_decode($request[$name][0]) as $key => $item) {
                foreach ($request[$name] as $key => $item) {
                    // array_push($data, $item->value);
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = Combinations::makeCombinations($options);
        return view('backend.product.products.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'));
    }

    public function sku_combination_edit(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        else {
            $colors_active = 0;
        }

        $product_name = $request->name;
        $unit_price = $request->unit_price;

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $data = array();
                // foreach (json_decode($request[$name][0]) as $key => $item) {
                foreach ($request[$name] as $key => $item) {
                    // array_push($data, $item->value);
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = Combinations::makeCombinations($options);
        return view('backend.product.products.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product'));
    }
	public function update_tags(Request $request)
    {
		$html = "";
		$category_id = $_POST["category_id"]; 
		$keywords = array();
		$data=array();
		$products = \App\Product::select('tags')->where('category_id', $category_id)->where('published', 1)->get();
		//echo '<select class="select2 form-control aiz-selectpicker" name="tags[]" data-toggle="select2" data-placeholder="Choose ..."data-live-search="true" multiple>';
		foreach ($products as $key => $product) {
		 
			foreach (explode(',',$product->tags) as $key => $tag) {
				if($tag != ''){
					array_push($keywords, strtolower($tag));
					array_push($data,array("id"=>$tag,"text"=>$tag));
					//echo "<option value='".$tag."'>".$tag."</option>";
				}
				
			}
		} 
		//echo "</select>";
        return $data;
    }

     public function google_feed_0(Request $request)
    {

        // return "Under maintenance. Pls, come after some time";
        $count = Product::where('published',1)->where('approved',1)->count();
		// $skip = 10000;
		$limit = 10000; 
		
        $products = Product::orderBy('id', 'asc')->where('published',1)->where('approved',1)
        // ->offset($skip)
        ->take($limit)->get();
        //$products = Product::orderBy('created_at', 'desc')->where('published',1)->where('approved',1)->get();	
        // $products = Product::orderBy('id', 'desc')->where('published',1)->where('approved',1)->skip(500)->get();	
        //$products = Product::orderBy('created_at', 'desc')->where('published',1)->where('approved',1)->get();	
        // $data = array(); 		
		
		$xml = '<rss xmlns:g="http://base.google.com/ns/1.0" xmlns:c="http://base.google.com/cns/1.0" version="2.0" encoding="UTF-8">
		<channel>
		<title><![CDATA[ Sadar24 ]]></title>
		<link><![CDATA[ https://sadar24.com/ ]]></link>
		<description><![CDATA[ Flat 25% Discount on All Product. Use Coupon Code - MERRY25. Choose from a vast selection of the best quality products. 100% Purchase protection. ]]></description>
		';
        
            foreach($products as $key => $row)  
                {  
                    $sub_array = array(); 	
    
                    $sub_array['unique_id']   = $row->id;
                    $sub_array['title']       = !empty($row->name)  ? strip_tags($row->name): '';
                    $description = !empty($row->description)  ? strip_tags($row->description): '';
                    $sub_array['product_link']= url('product/'.$row->slug);
                    $sub_array['condition']   = !empty($row->name)  ? strip_tags($row->name): '';
                    $sub_array['price']       = !empty($row->unit_price) ? $row->unit_price : '';
                    $sub_array['sale_price']       = !empty($row->unit_price) ? $row->unit_price - $row->discount : '';
                    if($row->current_stock > 0){
                        $sub_array['availability']  = 'in_stock';
                    } else {
                        $sub_array['availability']  = 'out_of_stock';
                    }		
                    $sub_array['current_stock']= !empty($row->current_stock) ? $row->current_stock : ''; 
                    $sub_array['brand']        = !empty($row->brand_id) ? $row->brand_id : '';	
                    $sub_array['image_link']   =  uploaded_asset($row->thumbnail_img);
                    
                    $category = DB::table('categories')->where('id', $row->category_id)->pluck('name')->first();
                    $category_name = !empty($category) ? strip_tags($category) : '';
                    $sub_array['sub_category'] = $category_name;	
                    
                $data[]       = $sub_array; 
                
                
                $xml .= '<item>
                        <g:id><![CDATA[ '.$sub_array['unique_id'].' ]]></g:id>
                                <g:title><![CDATA[ '.$sub_array['title'].' ]]></g:title>
                        <g:description><![CDATA[ '.trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($description)))))).' ]]></g:description>
                        <g:brand><![CDATA[ '.$sub_array['brand'].' ]]></g:brand>
                        <g:price><![CDATA[ '.$sub_array['price'].' INR'.' ]]></g:price>
                        <g:sale_price><![CDATA['.$sub_array['sale_price'].' INR'.']]></g:sale_price>
                        <link><![CDATA[ '.$sub_array['product_link'].' ]]></link>
                        <g:availability><![CDATA[ '.$sub_array['availability'].' ]]></g:availability>
                        <g:image_link><![CDATA[ '.$sub_array['image_link'].' ]]></g:image_link>
                        <g:product_type><![CDATA[ '.preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $category_name).' ]]></g:product_type>
                           </item>'; 
            } 
        // }		   
		$xml .= '</channel></rss>';	
		return response($xml, 200)->header('Content-Type', 'application/xml');
    }
    public function google_feed_1(Request $request)
    {

        // return "Under maintenance. Pls, come after some time";
        $count = Product::where('published',1)->where('approved',1)->count();
		$skip = 10000;
		$limit = 10000;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ; 
		
        $products = Product::orderBy('id', 'asc')->where('published',1)->where('approved',1)->offset($skip)->take($limit)->get();
        //$products = Product::orderBy('created_at', 'desc')->where('published',1)->where('approved',1)->get();	
        // $products = Product::orderBy('id', 'desc')->where('published',1)->where('approved',1)->skip(500)->get();	
        //$products = Product::orderBy('created_at', 'desc')->where('published',1)->where('approved',1)->get();	
        // $data = array(); 		
		
		$xml = '<rss xmlns:g="http://base.google.com/ns/1.0" xmlns:c="http://base.google.com/cns/1.0" version="2.0" encoding="UTF-8">
		<channel>
		<title><![CDATA[ Sadar24 ]]></title>
		<link><![CDATA[ https://sadar24.com/ ]]></link>
		<description><![CDATA[ Flat 25% Discount on All Product. Use Coupon Code - MERRY25. Choose from a vast selection of the best quality products. 100% Purchase protection. ]]></description>
		';
        
            foreach($products as $key => $row)  
                {                                           
                    $sub_array = array(); 	
    
                    $sub_array['unique_id']   = $row->id;
                    $sub_array['title']       = !empty($row->name)  ? strip_tags($row->name): '';
                    $description = !empty($row->description)  ? strip_tags($row->description): '';
                    $sub_array['product_link']= url('product/'.$row->slug);
                    $sub_array['condition']   = !empty($row->name)  ? strip_tags($row->name): '';
                    $sub_array['price']       = !empty($row->unit_price) ? $row->unit_price : '';
                    $sub_array['sale_price']       = !empty($row->unit_price) ? $row->unit_price - $row->discount : '';
                    if($row->current_stock > 0){
                        $sub_array['availability']  = 'in_stock';
                    } else {
                        $sub_array['availability']  = 'out_of_stock';
                    }		
                    $sub_array['current_stock']= !empty($row->current_stock) ? $row->current_stock : ''; 
                    $sub_array['brand']        = !empty($row->brand_id) ? $row->brand_id : '';	
                    $sub_array['image_link']   =  uploaded_asset($row->thumbnail_img);
                    
                    $category = DB::table('categories')->where('id', $row->category_id)->pluck('name')->first();
                    $category_name = !empty($category) ? strip_tags($category) : '';
                    $sub_array['sub_category'] = $category_name;	
                    
                $data[]       = $sub_array; 
                
                
                $xml .= '<item>
                        <g:id><![CDATA[ '.$sub_array['unique_id'].' ]]></g:id>
                                <g:title><![CDATA[ '.$sub_array['title'].' ]]></g:title>
                        <g:description><![CDATA[ '.trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($description)))))).' ]]></g:description>
                        <g:brand><![CDATA[ '.$sub_array['brand'].' ]]></g:brand>
                        <g:price><![CDATA[ '.$sub_array['price'].' INR'.' ]]></g:price>
                        <g:sale_price><![CDATA['.$sub_array['sale_price'].' INR'.']]></g:sale_price>
                        <link><![CDATA[ '.$sub_array['product_link'].' ]]></link>
                        <g:availability><![CDATA[ '.$sub_array['availability'].' ]]></g:availability>
                        <g:image_link><![CDATA[ '.$sub_array['image_link'].' ]]></g:image_link>
                        <g:product_type><![CDATA[ '.preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $category_name).' ]]></g:product_type>
                           </item>'; 
            } 
        // }		   
		$xml .= '</channel></rss>';	
		return response($xml, 200)->header('Content-Type', 'application/xml');
    }
    public function google_feed_2(Request $request)
    {

        // return "Under maintenance. Pls, come after some time";
        $count = Product::where('published',1)->where('approved',1)->count();
		$skip = 20000;
		$limit = 10000; 
		
        $products = Product::orderBy('id', 'asc')->where('published',1)->where('approved',1)->offset($skip)->take($limit)->get();
        //$products = Product::orderBy('created_at', 'desc')->where('published',1)->where('approved',1)->get();	
        // $products = Product::orderBy('id', 'desc')->where('published',1)->where('approved',1)->skip(500)->get();	
        //$products = Product::orderBy('created_at', 'desc')->where('published',1)->where('approved',1)->get();	
        // $data = array(); 		
		
		$xml = '<rss xmlns:g="http://base.google.com/ns/1.0" xmlns:c="http://base.google.com/cns/1.0" version="2.0" encoding="UTF-8">
		<channel>
		<title><![CDATA[ Sadar24 ]]></title>
		<link><![CDATA[ https://sadar24.com/ ]]></link>
		<description><![CDATA[ Flat 25% Discount on All Product. Use Coupon Code - MERRY25. Choose from a vast selection of the best quality products. 100% Purchase protection. ]]></description>
		';
        
            foreach($products as $key => $row)  
                {  
                    $sub_array = array(); 	
    
                    $sub_array['unique_id']   = $row->id;
                    $sub_array['title']       = !empty($row->name)  ? strip_tags($row->name): '';
                    $description = !empty($row->description)  ? strip_tags($row->description): '';
                    $sub_array['product_link']= url('product/'.$row->slug);
                    $sub_array['condition']   = !empty($row->name)  ? strip_tags($row->name): '';
                    $sub_array['price']       = !empty($row->unit_price) ? $row->unit_price : '';
                    $sub_array['sale_price']       = !empty($row->unit_price) ? $row->unit_price - $row->discount : '';
                    if($row->current_stock > 0){
                        $sub_array['availability']  = 'in_stock';
                    } else {
                        $sub_array['availability']  = 'out_of_stock';
                    }		
                    $sub_array['current_stock']= !empty($row->current_stock) ? $row->current_stock : ''; 
                    $sub_array['brand']        = !empty($row->brand_id) ? $row->brand_id : '';	
                    $sub_array['image_link']   =  uploaded_asset($row->thumbnail_img);
                    
                    $category = DB::table('categories')->where('id', $row->category_id)->pluck('name')->first();
                    $category_name = !empty($category) ? strip_tags($category) : '';
                    $sub_array['sub_category'] = $category_name;	
                    
                $data[]       = $sub_array; 
                
                
                $xml .= '<item>
                        <g:id><![CDATA[ '.$sub_array['unique_id'].' ]]></g:id>
                                <g:title><![CDATA[ '.$sub_array['title'].' ]]></g:title>
                        <g:description><![CDATA[ '.trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($description)))))).' ]]></g:description>
                        <g:brand><![CDATA[ '.$sub_array['brand'].' ]]></g:brand>
                        <g:price><![CDATA[ '.$sub_array['price'].' INR'.' ]]></g:price>
                        <g:sale_price><![CDATA['.$sub_array['sale_price'].' INR'.']]></g:sale_price>
                        <link><![CDATA[ '.$sub_array['product_link'].' ]]></link>
                        <g:availability><![CDATA[ '.$sub_array['availability'].' ]]></g:availability>
                        <g:image_link><![CDATA[ '.$sub_array['image_link'].' ]]></g:image_link>
                        <g:product_type><![CDATA[ '.preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $category_name).' ]]></g:product_type>
                           </item>'; 
            } 
        // }		   
		$xml .= '</channel></rss>';	
		return response($xml, 200)->header('Content-Type', 'application/xml');
    }
    public function google_feed_3(Request $request)
    {

        // return "Under maintenance. Pls, come after some time";
        $count = Product::where('published',1)->where('approved',1)->count();
		$skip = 30000;
		$limit = $count - $skip; 
		
        $products = Product::orderBy('id', 'asc')->where('published',1)->where('approved',1)->offset($skip)->take($limit)->get();
        //$products = Product::orderBy('created_at', 'desc')->where('published',1)->where('approved',1)->get();	
        // $products = Product::orderBy('id', 'desc')->where('published',1)->where('approved',1)->skip(500)->get();	
        //$products = Product::orderBy('created_at', 'desc')->where('published',1)->where('approved',1)->get();	
        // $data = array(); 		
		
		$xml = '<rss xmlns:g="http://base.google.com/ns/1.0" xmlns:c="http://base.google.com/cns/1.0" version="2.0" encoding="UTF-8">
		<channel>
		<title><![CDATA[ Sadar24 ]]></title>
		<link><![CDATA[ https://sadar24.com/ ]]></link>
		<description><![CDATA[ Flat 25% Discount on All Product. Use Coupon Code - MERRY25. Choose from a vast selection of the best quality products. 100% Purchase protection. ]]></description>
		';
        
            foreach($products as $key => $row)  
                {  
                    $sub_array = array(); 	
    
                    $sub_array['unique_id']   = $row->id;
                    $sub_array['title']       = !empty($row->name)  ? strip_tags($row->name): '';
                    $description = !empty($row->description)  ? strip_tags($row->description): '';
                    $sub_array['product_link']= url('product/'.$row->slug);
                    $sub_array['condition']   = !empty($row->name)  ? strip_tags($row->name): '';
                    $sub_array['price']       = !empty($row->unit_price) ? $row->unit_price : '';
                    $sub_array['sale_price']       = !empty($row->unit_price) ? $row->unit_price - $row->discount : '';
                    if($row->current_stock > 0){
                        $sub_array['availability']  = 'in_stock';
                    } else {
                        $sub_array['availability']  = 'out_of_stock';
                    }		
                    $sub_array['current_stock']= !empty($row->current_stock) ? $row->current_stock : ''; 
                    $sub_array['brand']        = !empty($row->brand_id) ? $row->brand_id : '';	
                    $sub_array['image_link']   =  uploaded_asset($row->thumbnail_img);
                    
                    $category = DB::table('categories')->where('id', $row->category_id)->pluck('name')->first();
                    $category_name = !empty($category) ? strip_tags($category) : '';
                    $sub_array['sub_category'] = $category_name;	
                    
                $data[]       = $sub_array; 
                
                
                $xml .= '<item>
                        <g:id><![CDATA[ '.$sub_array['unique_id'].' ]]></g:id>
                                <g:title><![CDATA[ '.$sub_array['title'].' ]]></g:title>
                        <g:description><![CDATA[ '.trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($description)))))).' ]]></g:description>
                        <g:brand><![CDATA[ '.$sub_array['brand'].' ]]></g:brand>
                        <g:price><![CDATA[ '.$sub_array['price'].' INR'.' ]]></g:price>
                        <g:sale_price><![CDATA['.$sub_array['sale_price'].' INR'.']]></g:sale_price>
                        <link><![CDATA[ '.$sub_array['product_link'].' ]]></link>
                        <g:availability><![CDATA[ '.$sub_array['availability'].' ]]></g:availability>
                        <g:image_link><![CDATA[ '.$sub_array['image_link'].' ]]></g:image_link>
                        <g:product_type><![CDATA[ '.preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $category_name).' ]]></g:product_type>
                           </item>'; 
            } 
        // }		   
		$xml .= '</channel></rss>';	
		return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function google_feed(Request $request)
    {
        // return "Under maintenance. Pls, come after some time";
        $count = Product::where('published',1)->where('approved',1)->count();
		$skip = 5000;
		$limit = $count - $skip; 
		
        $products = Product::orderBy('id', 'asc')->where('published',1)->where('approved',1)->offset($skip)->take($limit)->get();
        //$products = Product::orderBy('created_at', 'desc')->where('published',1)->where('approved',1)->get();	
        // $products = Product::orderBy('id', 'desc')->where('published',1)->where('approved',1)->skip(500)->get();	
        //$products = Product::orderBy('created_at', 'desc')->where('published',1)->where('approved',1)->get();	

	
		$data = array(); 		
		
		$xml = '<rss xmlns:g="http://base.google.com/ns/1.0" xmlns:c="http://base.google.com/cns/1.0" version="2.0" encoding="UTF-8">
		<channel>
		<title><![CDATA[ Sadar24 ]]></title>
		<link><![CDATA[ https://sadar24.com/ ]]></link>
		<description><![CDATA[ Flat 25% Discount on All Product. Use Coupon Code - MERRY25. Choose from a vast selection of the best quality products. 100% Purchase protection. ]]></description>
		';
		
		foreach($products as $key => $row)  
			{  
                $sub_array = array(); 	

				$sub_array['unique_id']   = $row->id;
				$sub_array['title']       = !empty($row->name)  ? strip_tags($row->name): '';
				$description = !empty($row->description)  ? strip_tags($row->description): '';
				$sub_array['product_link']= url('product/'.$row->slug);
				$sub_array['condition']   = !empty($row->name)  ? strip_tags($row->name): '';
				$sub_array['price']       = !empty($row->unit_price) ? $row->unit_price : '';
                    $sub_array['sale_price']       = !empty($row->unit_price) ? $row->unit_price - $row->discount : '';
				if($row->current_stock > 0){
                    $sub_array['availability']  = 'in_stock';
                } else {
                    $sub_array['availability']  = 'out_of_stock';
                }		
				$sub_array['current_stock']= !empty($row->current_stock) ? $row->current_stock : ''; 
				$sub_array['brand']        = !empty($row->brand_id) ? $row->brand_id : '';	
                $sub_array['image_link']   =  uploaded_asset($row->thumbnail_img);
				
				$category = \App\Category::select('name')->where('id', $row->category_id)->first();
				$category_name = !empty($category->name) ? strip_tags($category->name) : '';
				$sub_array['sub_category'] = $category_name;	
				
			$data[]       = $sub_array; 
			
			
			$xml .= '<item>
					<g:id><![CDATA[ '.$sub_array['unique_id'].' ]]></g:id>
							<g:title><![CDATA[ '.$sub_array['title'].' ]]></g:title>
					<g:description><![CDATA[ '.trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($description)))))).' ]]></g:description>
					<g:brand><![CDATA[ '.$sub_array['brand'].' ]]></g:brand>
					<g:price><![CDATA[ '.$sub_array['price'].' INR'.' ]]></g:price>
                    <g:sale_price><![CDATA['.$sub_array['sale_price'].' INR'.']]></g:sale_price>
					<link><![CDATA[ '.$sub_array['product_link'].' ]]></link>
					<g:availability><![CDATA[ '.$sub_array['availability'].' ]]></g:availability>
					<g:image_link><![CDATA[ '.$sub_array['image_link'].' ]]></g:image_link>
					<g:product_type><![CDATA[ '.preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $category_name).' ]]></g:product_type>
					   </item>'; 
		} 
        
		   
		$xml .= '</channel></rss>';	
		return response($xml, 200)->header('Content-Type', 'application/xml');
    }

}
