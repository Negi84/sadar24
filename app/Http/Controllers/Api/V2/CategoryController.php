<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Category;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V2\CategoryCollection;
use App\Http\Resources\V2\HomeSliderCollection;

class CategoryController extends Controller
{

    public function index($parent_id = 0)
    {
        if(request()->has('parent_id') && is_numeric (request()->get('parent_id'))){
          $parent_id = request()->get('parent_id');
        }
     
        return new CategoryCollection(DB::table('categories')->where('level', '=', 0)->orderBy('order_level','ASC')->get());
    }

    public function featured()
    {
        return new CategoryCollection(Category::where('featured', 1)->get());
    }

    public function home()
    {
        $homepageCategories = BusinessSetting::where('type', 'home_categories')->first();
        $homepageCategories = json_decode($homepageCategories->value);
        return new CategoryCollection(Category::whereIn('id', $homepageCategories)->get());
    }

    public function top()
    {
        // $homepageCategories = BusinessSetting::where('type', 'home_categories')->first();
        // $homepageCategories = json_decode($homepageCategories->value);

        $home_banner_links = [];
        $homeBanner = BusinessSetting::where('type', 'home_slider_images')->first();
        $homeBanner = json_decode($homeBanner->value);
        $homelink = BusinessSetting::where('type', 'home_slider_links')->first();
        $homelink = json_decode($homelink->value);
        foreach ($homeBanner as $key=>$banner){
        $home_banner_links[$key]['file_name'] = $banner;
        $home_banner_links[$key]['link'] = str_replace("https://sadar24.com/category/","",$homelink[$key]);
        }
        $home_banner_links = new HomeSliderCollection($home_banner_links);
        return $home_banner_links;
        // return new CategoryCollection(Category::whereIn('id', $homepageCategories)->limit(20)->get());
    }
}
