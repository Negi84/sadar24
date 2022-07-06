<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V2\CategoryCollection;
use App\Http\Resources\V2\AllSubCategoryCollection;

class SubCategoryController extends Controller
{
    public function index($id)
    {
        // dd(new CategoryCollection(Category::where('parent_id', $id)->get()));
        return new CategoryCollection(DB::table('categories')->where('parent_id', $id)->orderBy('order_level','ASC')->get());
    }
    public function sub_category($id)
    {
        // dd(new CategoryCollection(Category::where('parent_id', $id)->get()));
        return new AllSubCategoryCollection(DB::table('categories')->where('parent_id', $id)->orderBy('order_level','ASC')->get());
    }
}
