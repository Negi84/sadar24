<?php

namespace App\Http\Controllers\Api\V2;

use Cache;
use App\Models\Product;
use App\Models\Category;
use App\Models\FlashDeal;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Http\Controllers\Controller;
use App\Http\Resources\V2\BannerCollection;
use App\Http\Resources\V2\ProductCollection;
use App\Http\Resources\V2\CategoryCollection;
use App\Http\Resources\V2\FlashDealCollection;
use App\Http\Resources\V2\HomeSliderCollection;
use App\Http\Resources\V2\ProductMiniCollection;

class HomeController extends Controller
{
    public function home(){

        $home_categories_api = new CategoryCollection(Cache::remember('home_categories_api', 3600, function () {
            $homepageCategories = BusinessSetting::where('type', 'home_categories')->first();
        $homepageCategories = json_decode($homepageCategories->value);
        return Category::whereIn('id', $homepageCategories)->get();    
        }));
        
        $home_banner_links_api = new BannerCollection(Cache::remember('home_banner_links_api', 3600, function () {
            $home_banner_links_api = [];
            $homeBanner = BusinessSetting::where('type', 'home_slider_images')->first();
            $homeBanner = json_decode($homeBanner->value);
            $homelink = BusinessSetting::where('type', 'home_slider_links')->first();
            $homelink = json_decode($homelink->value);
            foreach ($homeBanner as $key=>$banner){
            $home_banner_links_api[$key]['file_name'] = $banner;
            $home_banner_links_api[$key]['link'] = (string)Category::where('slug',str_replace("https://sadar24.com/category/","",$homelink[$key]))->pluck('id')->first();
            }
            return $home_banner_links_api;
        }));

        $price_discount_banner_links_api = new BannerCollection(Cache::remember('price_discount_banner_links_api', 3600, function () {
            $price_discount_banner_links_api = [];
            $price_discount_banner = BusinessSetting::where('type', 'home_banner2_images')->first();
            $price_discount_banner = json_decode($price_discount_banner->value);
            $price_discount_link = BusinessSetting::where('type', 'home_banner2_links')->first();
            $price_discount_link = json_decode($price_discount_link->value);
            foreach ($price_discount_banner as $key=>$banner){
            $price_discount_banner_links_api[$key]['file_name'] = $banner;
            $price_discount_banner_links_api[$key]['link'] = str_replace("https://sadar24.com/search?","https://sadar24.com/api/v2/products/search?",$price_discount_link[$key]);
            }
            return $price_discount_banner_links_api;
        }));
       
        $sponsored_banner_links_api = new BannerCollection(Cache::remember('sponsored_banner_links_api', 3600, function () {
            $sponsored_banner_links_api = [];
        $sponsored_banner = BusinessSetting::where('type', 'sponsored_images')->first();
        $sponsored_banner = json_decode($sponsored_banner->value);
        $sponsored_link = BusinessSetting::where('type', 'sponsored_links')->first();
        $sponsored_link = json_decode($sponsored_link->value);
        foreach ($sponsored_banner as $key=>$banner){
        $sponsored_banner_links_api[$key]['file_name'] = $banner;
        $sponsored_banner_links_api[$key]['link'] = (string)Category::where('slug',str_replace("https://sadar24.com/category/","",$sponsored_link[$key]))->pluck('id')->first();
        }
        return $sponsored_banner_links_api;
        }));
        
        $featured_card_banner_links_api = Cache::remember('featured_card_banner_links_api', 3600, function () {
            $i = 0;
            $status = 'true';
            $featured_card_banner_links_api = [];
                while($status == 'true'){
                    if(get_setting('offer_card_title_' . $i, null) != null){
                        $featured_card_banner_links_api['data'][$i]['offer_card_title'] = BusinessSetting::where('type', 'offer_card_title_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['offer_card_title'] = $featured_card_banner_links_api['data'][$i]['offer_card_title']['value'];
                        $featured_card_banner_links_api['data'][$i]['offer_card_bg_color'] = BusinessSetting::where('type', 'offer_card_bg_color_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['offer_card_bg_color'] = $featured_card_banner_links_api['data'][$i]['offer_card_bg_color']['value'];
    
                        $featured_card_banner_links_api['data'][$i]['first_offer_card_img'] = BusinessSetting::where('type', 'first_offer_card_img_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['first_offer_card_img'] = api_asset($featured_card_banner_links_api['data'][$i]['first_offer_card_img']['value']);
                        $featured_card_banner_links_api['data'][$i]['first_offer_category'] = BusinessSetting::where('type', 'first_offer_category_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['first_offer_category'] = $featured_card_banner_links_api['data'][$i]['first_offer_category']['value'];
                        $featured_card_banner_links_api['data'][$i]['first_offer_heading'] = BusinessSetting::where('type', 'first_offer_heading_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['first_offer_heading'] = $featured_card_banner_links_api['data'][$i]['first_offer_heading']['value'];
                        $featured_card_banner_links_api['data'][$i]['first_offer_link_slug'] = BusinessSetting::where('type', 'first_offer_link_slug_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['first_offer_link_slug'] = str_replace("https://sadar24.com/category/","",$featured_card_banner_links_api['data'][$i]['first_offer_link_slug']['value']);
                        $featured_card_banner_links_api['data'][$i]['first_offer_link_slug'] = (string)Category::where('slug',$featured_card_banner_links_api['data'][$i]['first_offer_link_slug'])->pluck('id')->first();
    
                        $featured_card_banner_links_api['data'][$i]['second_offer_card_img'] = BusinessSetting::where('type', 'second_offer_card_img_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['second_offer_card_img'] = api_asset($featured_card_banner_links_api['data'][$i]['second_offer_card_img']['value']);
                        $featured_card_banner_links_api['data'][$i]['second_offer_category'] = BusinessSetting::where('type', 'second_offer_category_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['second_offer_category'] = $featured_card_banner_links_api['data'][$i]['second_offer_category']['value'];
                        $featured_card_banner_links_api['data'][$i]['second_offer_heading'] = BusinessSetting::where('type', 'second_offer_heading_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['second_offer_heading'] = $featured_card_banner_links_api['data'][$i]['second_offer_heading']['value'];
                        $featured_card_banner_links_api['data'][$i]['second_offer_link_slug'] = BusinessSetting::where('type', 'second_offer_link_slug_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['second_offer_link_slug'] = str_replace("https://sadar24.com/category/","",$featured_card_banner_links_api['data'][$i]['second_offer_link_slug']['value']);
                        $featured_card_banner_links_api['data'][$i]['second_offer_link_slug'] = (string)Category::where('slug',$featured_card_banner_links_api['data'][$i]['second_offer_link_slug'])->pluck('id')->first();
    
                        $featured_card_banner_links_api['data'][$i]['third_offer_card_img'] = BusinessSetting::where('type', 'third_offer_card_img_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['third_offer_card_img'] = api_asset($featured_card_banner_links_api['data'][$i]['third_offer_card_img']['value']);
                        $featured_card_banner_links_api['data'][$i]['third_offer_category'] = BusinessSetting::where('type', 'third_offer_category_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['third_offer_category'] = $featured_card_banner_links_api['data'][$i]['third_offer_category']['value'];
                        $featured_card_banner_links_api['data'][$i]['third_offer_heading'] = BusinessSetting::where('type', 'third_offer_heading_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['third_offer_heading'] = $featured_card_banner_links_api['data'][$i]['third_offer_heading']['value'];
                        $featured_card_banner_links_api['data'][$i]['third_offer_link_slug'] = BusinessSetting::where('type', 'third_offer_link_slug_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['third_offer_link_slug'] = str_replace("https://sadar24.com/category/","",$featured_card_banner_links_api['data'][$i]['third_offer_link_slug']['value']);
                        $featured_card_banner_links_api['data'][$i]['third_offer_link_slug'] = (string)Category::where('slug',$featured_card_banner_links_api['data'][$i]['third_offer_link_slug'])->pluck('id')->first();
    
                        $featured_card_banner_links_api['data'][$i]['fourth_offer_card_img'] = BusinessSetting::where('type', 'fourth_offer_card_img_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['fourth_offer_card_img'] = api_asset($featured_card_banner_links_api['data'][$i]['fourth_offer_card_img']['value']);
                        $featured_card_banner_links_api['data'][$i]['fourth_offer_category'] = BusinessSetting::where('type', 'fourth_offer_category_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['fourth_offer_category'] = $featured_card_banner_links_api['data'][$i]['fourth_offer_category']['value'];
                        $featured_card_banner_links_api['data'][$i]['fourth_offer_heading'] = BusinessSetting::where('type', 'fourth_offer_heading_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['fourth_offer_heading'] = $featured_card_banner_links_api['data'][$i]['fourth_offer_heading']['value'];
                        $featured_card_banner_links_api['data'][$i]['fourth_offer_link_slug'] = BusinessSetting::where('type', 'fourth_offer_link_slug_' . $i)->first();
                        $featured_card_banner_links_api['data'][$i]['fourth_offer_link_slug'] = str_replace("https://sadar24.com/category/","",$featured_card_banner_links_api['data'][$i]['fourth_offer_link_slug']['value']);
                        $featured_card_banner_links_api['data'][$i]['fourth_offer_link_slug'] = (string)Category::where('slug',$featured_card_banner_links_api['data'][$i]['fourth_offer_link_slug'])->pluck('id')->first();
                    
                        $i = ++$i; 
                        }
                        else{
                        if($i == 0){
                            $i = ++$i; 
                            }
                        $status = 'false';
                    }   
                } 
        return $featured_card_banner_links_api;
        });
        $best_sellers_api =  new ProductMiniCollection(Cache::remember('featured_products_api', 3600, function () {
            $featured_products_api = Product::where('featured', 1)->where('holiday', 1);
            return filter_products($featured_products_api)->latest()->limit(10)->get();
        }));
        
        $home_products_api = new ProductCollection(Cache::remember('home_products_api', 3600, function () {
            return Product::inRandomOrder()->take(50)->get();
        }));

        $todays_deal_products_api = new ProductMiniCollection(Cache::remember('todays_deal_products_api', 3600, function () {
            $todays_deal_products_api = Product::where('todays_deal', 1)->where('holiday', 1);
            return  filter_products($todays_deal_products_api)->limit(20)->latest()->get();
        }));

        $featured_products_api = new ProductMiniCollection(Cache::remember('best_sellers_api', 3600, function () {
            $products = Product::orderBy('num_of_sale', 'desc')->where('holiday', 1);
            return filter_products($products)->limit(20)->get();
        }));
        

        $flash_deals_api = new FlashDealCollection(Cache::remember('flash_deals_api', 3600, function () {
            $flash_deals_api = FlashDeal::where('status', 1)->where('featured', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->get();
            return $flash_deals_api;
        }));        

        $arr = array('status'=>true, 'home_categories'=>$home_categories_api,'home_banners'=>$home_banner_links_api,'featured_card_banner_links'=>$featured_card_banner_links_api,'price_discount'=>$price_discount_banner_links_api,'sponsored_banner_links'=>$sponsored_banner_links_api,'best_sellers'=>$best_sellers_api, 'home_products'=>$home_products_api, 'todays_deal_products'=>$todays_deal_products_api, 'featured_products'=>$featured_products_api, 'flash_deals'=>$flash_deals_api);
        return response()->json($arr);

    }
}
