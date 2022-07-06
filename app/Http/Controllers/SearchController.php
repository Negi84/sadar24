<?php

namespace App\Http\Controllers;

use Cache;
use App\Shop;
use App\Brand;
use App\Color;
use App\Search;
use App\Product;
use App\Category;
use App\Attribute;
use App\FlashDeal;
use App\AttributeCategory;
use Illuminate\Http\Request;
use App\Utility\CategoryUtility;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request, $category_id = null,$category_parent_id = null, $brand_id = null)
    {
        $query = $request->keyword;
        $sort_by = $request->sort_by;
        $min_price = $request->has('min') ? $request->min : 60;
        $max_price = $request->max_price;
        $seller_id = $request->seller_id;
        $attributes = Attribute::all();
        $selected_attribute_values = array();
        $colors = Color::all();
        $selected_color = null;
        $related_category = [];
        $price_range = [$min_price,$max_price];
        $conditions = ['published' => 1];
        if ($brand_id != null) {
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        } elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        if ($seller_id != null) {
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }

        $products = Product::where($conditions);

        if ($category_id != null) {
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $products->whereIn('category_id', $category_ids);

            $attribute_ids = AttributeCategory::whereIn('category_id', $category_ids)->pluck('attribute_id')->toArray();
            $attributes = Attribute::whereIn('id', $attribute_ids)->get();
        } else {
        }

        if ($min_price != null && $max_price != null) {
            $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        } else {
            $products->where('unit_price', '>=', 60);
        }

        if ($query != null) {
            $searchController = new SearchController;
            $searchController->store($request);

            $products->where(function ($q) use ($query) {
                foreach (explode(' ', trim($query)) as $word) {
                    $q->where('name', 'like', '%' . $word . '%')->orWhere('tags', 'like', '%' . $word . '%')->orWhereHas('product_translations', function ($q) use ($word) {
                        $q->where('name', 'like', '%' . $word . '%');
                    });
                }
            });
        }
        
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

        if ($request->has('color')) {
            $str = '"' . $request->color . '"';
            $products->where('colors', 'like', '%' . $str . '%');
            $selected_color = $request->color;
        }

        if ($request->has('selected_attribute_values')) {
            $selected_attribute_values = $request->selected_attribute_values;
            foreach ($selected_attribute_values as $key => $value) {
                $str = '"' . $value . '"';
                $products->where('choice_options', 'like', '%' . $str . '%');
            }
        }
        $products->where('holiday', 1);
        $products = filter_products($products)->with('taxes')->paginate(60)->appends(request()->query());
        // dd($category_id);
        $related_category = DB::table('categories')
            ->where('parent_id', '=', $category_parent_id)
            ->select('name', 'parent_id', 'level', 'id', 'slug')
            ->get();
        // dd($related_category);
        return view('frontend.product_listing', compact('products', 'query', 'category_id', 'related_category', 'brand_id', 'sort_by', 'seller_id', 'min_price', 'max_price', 'attributes', 'selected_attribute_values', 'colors', 'selected_color'));
    }

    public function listing(Request $request)
    {
        return $this->index($request);
    }

    public function listingByCategory(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        // dd($category);
        if ($category != null) {
            return $this->index($request, $category->id,$category->parent_id);
        }
        abort(404);
    }

    public function listingByBrand(Request $request, $brand_slug)
    {
        $brand = Brand::where('slug', $brand_slug)->first();
        if ($brand != null) {
            return $this->index($request, null, $brand->id);
        }
        abort(404);
    }

    //Suggestional Search
    public function ajax_search(Request $request)
    {
        $keywords = array();
        $query = $request->search;
        $products = Product::where('published', 1)->where('tags', 'like', '%' . $query . '%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',', $product->tags) as $key => $tag) {
                //if(stripos($tag, $query) !== false){
                if ($query && strpos($tag, $query) === FALSE) {
                    if (sizeof($keywords) > 5) {
                        break;
                    } else {
                        if (!in_array(strtolower($tag), $keywords)) {
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }

        $products = filter_products(Product::query());

        $products = $products->where('published', 1)
            ->where(function ($q) use ($query) {
                foreach (explode(' ', trim($query)) as $word) {
                    $q->where('name', 'like', '%' . $word . '%')->orWhere('tags', 'like', '%' . $word . '%')->orWhereHas('product_translations', function ($q) use ($word) {
                        $q->where('name', 'like', '%' . $word . '%');
                    });
                }
            })
            ->get();

        $categories = Category::where('name', 'like', '%' . $query . '%')->get()->take(3);

        $shops = Shop::whereIn('user_id', verified_sellers_id())->where('name', 'like', '%' . $query . '%')->get()->take(3);

        if (sizeof($keywords) > 0 || sizeof($categories) > 0 || sizeof($products) > 0 || sizeof($shops) > 0) {
            return view('frontend.partials.search_content', compact('products', 'categories', 'keywords', 'shops'));
        }
        return '0';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $search = Search::where('query', $request->keyword)->first();
        if ($search != null) {
            $search->count = $search->count + 1;
            $search->save();
        } else {
            $search = new Search;
            $search->query = $request->keyword;
            $search->save();
        }
    }

    public function ajax_search_pred(Request $request)
    {        
        Cache::flush();
        $keywords_new = Cache::remember('keywords_new', 3600, function () {
            $keywords = array();
            $products = DB::table('products')->select('tags')->where('tags','!=',"")->where('published', 1)->pluck('tags');
            foreach ($products as $key => $product) {
                foreach (explode(',', $product) as $key => $tag) {
                    if ($tag != '') {
                        array_push($keywords, strtolower($tag));
                    }
                }
            }
            $keywords_new = array();
            $results = array_unique($keywords);            
            foreach ($results as $key => $result) {
                array_push($keywords_new, strtolower($result));
            }
            return $keywords_new;
        });

        
        return $keywords_new;
    }
    public function smart_search_backup(Request $request, $category_id = null, $brand_id = null)
    {
        $query = $request->keyword;
        $sort_by = $request->sort_by;
        $min_price = 60;
        $max_price = $request->max_price;
        $seller_id = $request->seller_id;
        $attributes = Attribute::all();
        $selected_attribute_values = array();
        $colors = Color::all();
        $selected_color = null;

        $conditions = ['published' => 1];

        if ($request->sort_by == '') {
            $sort_by = 'price-asc';
        } else {
            $sort_by = $request->sort_by;
        }


        if ($brand_id != null) {
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        } elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        if ($seller_id != null) {
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }

        $products = Product::where($conditions);

        if ($category_id != null) {
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $products->whereIn('category_id', $category_ids);

            $attribute_ids = AttributeCategory::whereIn('category_id', $category_ids)->pluck('attribute_id')->toArray();
            $attributes = Attribute::whereIn('id', $attribute_ids)->get();
        } else {
        }
        if ($min_price != null && $max_price != null) {
            $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        } else {
            $products->where('unit_price', '>=', 60);
        }

        if ($query != null) {
            $searchController = new SearchController;
            $searchController->store($request);
            $key = 0;
            $keyword = trim($query);
            $search_keywords = DB::table('search_keywords')
                ->whereRaw("FIND_IN_SET('$keyword',value)")
                ->get();
            if (!$search_keywords->isEmpty()) {
                $final_query = "";
                foreach ($search_keywords as $search_keyword) {
                    $final_query = explode(",", $search_keyword->value);
                }
                foreach ($final_query as $word) {

                    $products->where('name', 'like', '%' . $word . '%')->orWhere('tags', 'like', '%' . $word . '%');
                }
            } else {
                $products->where(function ($q) use ($query) {
                    $q->where('tags', 'like', '' . $query . '')->orWhere('tags', 'like', '' . $query . '%')->orWhere('tags', 'like', '%' . $query . '%')->orWhere('name', 'like', '' . $query . '%')->orWhere('name', 'like', '%' . $query . '')->orWhere('name', 'like', '%' . $query . '%');
                    foreach (explode(' ', trim($query)) as $word) {
                        $q->where('name', 'like', '%' . $word . '%')->orWhere('tags', 'like', '%' . $word . '%');
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
                $products->orderByRaw("case when `tags` LIKE '" . $query . "' then 1
				when `name` LIKE '" . $query . "' then 2
				when `tags` LIKE '" . $query . "%'  then 3 
				when `tags` LIKE '%" . $query . "%'  then 4 
				when `name` LIKE '" . $query . "%'  then 5
				when `name` LIKE '%" . $query . "%'  then 6 
				end desc");

                break;
        }

        if ($request->has('color')) {
            $str = '"' . $request->color . '"';
            $products->where('colors', 'like', '%' . $str . '%');
            $selected_color = $request->color;
        }

        if ($request->has('selected_attribute_values')) {
            $selected_attribute_values = $request->selected_attribute_values;
            foreach ($selected_attribute_values as $key => $value) {
                $str = '"' . $value . '"';
                $products->where('choice_options', 'like', '%' . $str . '%');
            }
        }

        $products = filter_products($products)->with('taxes')->paginate(40)->appends(request()->query());
        $related_category = DB::table('categories')
            ->where('parent_id', '=', 0)
            ->select('name', 'parent_id', 'level', 'id', 'slug')
            ->get();
        return view('frontend.product_listing', compact('products', 'query', 'category_id', 'brand_id', 'sort_by', 'seller_id', 'min_price', 'max_price', 'attributes', 'selected_attribute_values', 'colors', 'selected_color','related_category'));
    }
	
	 public function smart_search(Request $request, $category_id = null, $brand_id = null)
    {
        $query = $request->keyword;
        $sort_by = $request->sort_by;
        $min_price = 60;
        $max_price = $request->max_price;
        $seller_id = $request->seller_id;
        $attributes = Attribute::all();
        $selected_attribute_values = array();
        $colors = Color::all();
        $selected_color = null;

        $conditions = ['published' => 1];

       /*  if ($request->sort_by == '') {
            $sort_by = 'price-asc';
        } else {
            $sort_by = $request->sort_by;
        }
 */

        if ($brand_id != null) {
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        } elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        if ($seller_id != null) {
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }

        $products = Product::where($conditions);

        if ($category_id != null) {
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $products->whereIn('category_id', $category_ids);

            $attribute_ids = AttributeCategory::whereIn('category_id', $category_ids)->pluck('attribute_id')->toArray();
            $attributes = Attribute::whereIn('id', $attribute_ids)->get();
        } else {
			
        }
        if ($min_price != null && $max_price != null) {
            $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        } else {
            $products->where('unit_price', '>=', 60);
        }

        if ($query != null) {
            $searchController = new SearchController;
            $searchController->store($request);
            $key = 0;
            $keyword = trim($query);
            
			$search_keywords =Category::whereRaw("FIND_IN_SET('$keyword',keywords)")->get();			
			if (!$search_keywords->isEmpty()) { 
				$final_query ="";
				foreach($search_keywords as $search_keyword) {
					$products->Where('category_id', $search_keyword->id);
				}				
			}else{								
				$products->where(function ($q) use ($query){				
					$results = $q->whereRaw("FIND_IN_SET('$query',tags)")->count();	
					if($results){
						$q->whereRaw("FIND_IN_SET('$query',tags)");	
					}else{
						$q->where('name', 'like', ''.$query.'%')->orWhere('name', 'like', '%'.$query.'')->orWhere('name', 'like', '%'.$query.'%');
						foreach (explode(' ', trim($query)) as $word) {
							$q->where('name', 'like', '%'.$word.'%')->orWhere('tags', 'like', '%'.$word.'%');
						}
					}
				});				
			}
        }       
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

        if ($request->has('color')) {
            $str = '"' . $request->color . '"';
            $products->where('colors', 'like', '%' . $str . '%');
            $selected_color = $request->color;
        }

        if ($request->has('selected_attribute_values')) {
            $selected_attribute_values = $request->selected_attribute_values;
            foreach ($selected_attribute_values as $key => $value) {
                $str = '"' . $value . '"';
                $products->where('choice_options', 'like', '%' . $str . '%');
            }
        }
        $products->where('holiday', 1);
        $products = filter_products($products)->with('taxes')->paginate(40)->appends(request()->query());
        $related_category = DB::table('categories')
            ->where('parent_id', '=', 0)
            ->select('name', 'parent_id', 'level', 'id', 'slug')
            ->get();
        return view('frontend.product_listing', compact('products', 'query', 'category_id', 'brand_id', 'sort_by', 'seller_id', 'min_price', 'max_price', 'attributes', 'selected_attribute_values', 'colors', 'selected_color','related_category'));
    }
	
	
}
