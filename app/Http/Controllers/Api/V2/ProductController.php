<?php

namespace App\Http\Controllers\Api\V2;

use Auth;
use App\Upload;
use App\Attribute;
use App\Models\Cart;
use App\Models\Shop;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\FlashDeal;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Utility\SearchUtility;
use App\Http\Controllers\SearchController;
use App\Models\FlashDealProduct;
use App\Utility\CategoryUtility;
use App\Http\Resources\V2\ProductCollection;
use App\Http\Resources\V2\FlashDealCollection;
use App\Http\Resources\V2\ProductMiniCollection;
use App\Http\Resources\V2\ProductDetailCollection;
use App\Http\Resources\V2\SearchProductCollection;

class ProductController extends Controller
{
    public function index()
    {
        return new ProductMiniCollection(Product::latest()->paginate(10));
    }


    public function product(Request $request, $slug)
    {
    
    //dd($id);
        //$detailedProduct  = Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop')->where('slug', $slug)->where('approved', 1)->first();
        /* $detailedProduct  = Product::leftJoin('user', function($join) {
      $join->on('product.user_id', '=', 'user.id');
    })->leftJoin('shop', function($join) {
      $join->on('user.id', '=', 'shop.user_id');
    })->where('product.slug', $slug)
	->where('shop.holiday', 0)
	->first([
        'product.reviews', 'product.brand', 'product.stocks', 'product.user', 'user.shop'
    ]); */
        //dd($detailedProduct);
        /* $detailedProduct = DB::table('product')
            ->join('user', 'product.user_id', '=', 'user.id')
            ->join('shop', 'user.id', '=', 'shop.user_id')
			->where('product.slug', $slug)
			->where('shop.holiday', 0)
            ->select('product.*','user.*','shop.*')
            ->get(); */
        $detailedProduct  = Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop')->where('slug', $slug)->where('approved', 1)->first();
        // $detailedProduct  = new ProductDetailCollection(Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop')->where('id', $id)->where('approved', 1)->get());
    //    dd($detailedProduct);

       $refund_time_config = \App\BusinessSetting::where('type', 'refund_request_time')->first();
        if(!$detailedProduct){
            $arr = array('status'=>false, 'msg'=>'No such product found');
            return response()->json($arr);
        }else{

        // dd($detailedProduct);
        $photos_link = [];
        $photos_ids = explode(',', $detailedProduct->photos);
        foreach ($photos_ids as $ids){
            if($ids != 0){
            array_push($photos_link,Upload::where('id',$ids)->pluck('file_name')->first());
            }
        }
        $photos_link = implode(',',$photos_link);

        $detailedProduct->photos = $photos_link;
        if($detailedProduct->discount_type == "percent"){
        $detailedProduct->discount_type = "amount";
        $detailedProduct->discount_percent = $detailedProduct->discount;
        $detailedProduct->discount = round(($detailedProduct->unit_price * $detailedProduct->discount) / 100);
        }
        else{
        $detailedProduct->discount_percent = (int)round(($detailedProduct->discount/$detailedProduct->unit_price)*100);
        }
        $detailedProduct->refund_policy_days = $refund_time_config->value;
        // dd($detailedProduct);

        //dd(Auth::user());
		$cartStatus = 0;
		if(auth()->user()){
            $carts = Cart::where('user_id', auth()->user()->id)->get();
            
            foreach ($carts as $item) {
                if ($item->product_id == $detailedProduct->id) {
                    $cartStatus = 1;
                }
               }
            }
            $detailedProduct->choice_options = json_decode($detailedProduct->choice_options);
            foreach($detailedProduct->choice_options as $choice){
                $choice->attribute_id = (string)$choice->attribute_id;
                $choice->attribute_name = DB::table('attributes')->where('id',$choice->attribute_id)->pluck('name')->first();
            }
            $detailedProduct->colors = json_decode($detailedProduct->colors);
             $color_options = [];
            foreach($detailedProduct->colors as $key => $choice){
                $color_options[$key]['color_code'] = $choice;
                $color_options[$key]['color_name'] = Color::where('code', $choice)->first()->name;
            }
            $detailedProduct->colors = $color_options;
            $arr = array('status'=>true, 'msg'=>'', 'product'=>$detailedProduct, 'cartStatus'=>$cartStatus);
            return response()->json($arr);
        }

    }



    public function show($id)
    {
        return new ProductDetailCollection(Product::where('id', $id)->get());
    }

    public function admin()
    {
        return new ProductCollection(Product::where('added_by', 'admin')->latest()->paginate(10));
    }

    public function seller($id, Request $request)
    {
        $shop = Shop::findOrFail($id);
        $products = Product::where('added_by', 'seller')->where('user_id', $shop->user_id);
        if ($request->name != "" || $request->name != null) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }
        $products->where('published', 1);
        return new ProductMiniCollection($products->latest()->paginate(25));
    }

    public function category($id, Request $request)
    {
        $category_ids = CategoryUtility::children_ids($id);
        $category_ids[] = $id;

        $products = Product::whereIn('category_id', $category_ids);

        if ($request->name != "" || $request->name != null) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }
        $products->where('published', 1);
        $products->where('holiday', 1);
        return new ProductMiniCollection(filter_products($products)->latest()->paginate(25));
    }


    public function brand($id, Request $request)
    {
        $products = Product::where('brand_id', $id);
        if ($request->name != "" || $request->name != null) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }

        return new ProductMiniCollection(filter_products($products)->latest()->paginate(10));
    }

    public function todaysDeal()
    {
        $products = Product::where('todays_deal', 1);
        return new ProductMiniCollection(filter_products($products)->limit(20)->latest()->get());
    }

    public function flashDeal()
    {
        $flash_deals = FlashDeal::where('status', 1)->where('featured', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->get();
        return new FlashDealCollection($flash_deals);
    }

    public function featured()
    {
        $products = Product::where('featured', 1);
        return new ProductMiniCollection(filter_products($products)->latest()->paginate(10));
    }

    public function bestSeller()
    {
        $products = Product::orderBy('num_of_sale', 'desc');
        return new ProductMiniCollection(filter_products($products)->limit(20)->get());
    }

    public function related($id)
    {
        $product = Product::find($id);
        $products = Product::where('category_id', $product->category_id)->where('id', '!=', $id);
        return new ProductMiniCollection(filter_products($products)->limit(10)->get());
    }

    public function topFromSeller($id)
    {
        $product = Product::find($id);
        $products = Product::where('user_id', $product->user_id)->orderBy('num_of_sale', 'desc');
        return new ProductMiniCollection(filter_products($products)->limit(10)->get());
    }


    public function search(Request $request)
    {
        // dd($request->name);
        $category_ids = [];
        $brand_ids = [];
        if($request->name == "" && $request->categories == "" && $request->max == ""){
            $products = [];
            return new ProductMiniCollection($products);
        }
        if ($request->categories != null && $request->categories != "") {
            $category_ids = explode(',', $request->categories);
        }

        if ($request->brands != null && $request->brands != "") {
            $brand_ids = explode(',', $request->brands);
        }
        $sort_by = $request->sort_key;
        $name = $request->name;
        $min = 60;
        $max = $request->max;

        $products = Product::query();
        // $products = DB::table('products');
        // dd($products->get());
        $products->where('published', 1);

        if (!empty($brand_ids)) {
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($category_ids)) {
            $n_cid = [];
            foreach ($category_ids as $cid) {
                $n_cid = array_merge($n_cid, CategoryUtility::children_ids($cid));
            }

            if (!empty($n_cid)) {
                $category_ids = array_merge($category_ids, $n_cid);
            }

            $products->whereIn('category_id', $category_ids);
        }

        if ($min != null && $max != null) {
            $products->where('unit_price', '>=', $min)->where('unit_price', '<=', $max);
        } else {
            $products->where('unit_price', '>=', 60);
        }

        if ($name != null && $name != "") {
            SearchUtility::store($name);
            $key = 0;
            $keyword = trim($name);
            
			$search_keywords =Category::whereRaw("FIND_IN_SET('$keyword',keywords)")->get();			
			if (!$search_keywords->isEmpty()) { 
				$final_query ="";
				foreach($search_keywords as $search_keyword) {
					$products->Where('category_id', $search_keyword->id);
				}				
			}else{								
				$products->where(function ($q) use ($name){				
					$results = $q->whereRaw("FIND_IN_SET('$name',tags)")->count();	
					if($results){
						$q->whereRaw("FIND_IN_SET('$name',tags)");	
					}else{
						$q->where('name', 'like', ''.$name.'%')->orWhere('name', 'like', '%'.$name.'')->orWhere('name', 'like', '%'.$name.'%');
						foreach (explode(' ', trim($name)) as $word) {
							$q->where('name', 'like', '%'.$word.'%')->orWhere('tags', 'like', '%'.$word.'%');
						}
					}
				});				
			}
        }       
       
        $products->where('holiday', 1);
        switch ($sort_by) {
            case 'newest':
                $products->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $products->orderBy('created_at', 'asc');
                break;
            case 'price-asc':
                $products->orderBy('unit_price', 'asc');
                break;
            case 'price-desc':
                $products->orderBy('unit_price', 'desc');
                break;
            default:
                $products->orderBy('created_at', 'desc');
                break;
        }
        // dd(filter_products($products)->paginate(100));
    //    return new ProductMiniCollection(filter_products($products)->paginate(100));
        // $products = $products->get();
        return new ProductMiniCollection(filter_products($products)->paginate(25));
    }


    public function variantPrice(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $str = '';
        $tax = 0;

        if ($request->has('color') && $request->color != "") {
            $str = Color::where('code', '#' . $request->color)->first()->name;
        }

        $var_str = str_replace(',', '-', $request->variants);
        $var_str = str_replace(' ', '', $var_str);

        if ($var_str != "") {
            $temp_str = $str == "" ? $var_str : '-' . $var_str;
            $str .= $temp_str;
        }


        $product_stock = $product->stocks->where('variant', $str)->first();
        $price = $product_stock->price;
        $stockQuantity = $product_stock->qty;


        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }



        return response()->json([
            'product_id' => $product->id,
            'variant' => $str,
            'price' => (double)convert_price($price),
            'price_string' => format_price(convert_price($price)),
            'stock' => intval($stockQuantity),
            'image' => $product_stock->image == null ? "" : api_asset($product_stock->image)
        ]);
    }

    public function home()
    {
        return new ProductCollection(Product::inRandomOrder()->take(50)->get());
    }
}
