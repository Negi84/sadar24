<?php

namespace App\Http\Resources\V2;

use App\Models\Category;
use App\Utility\CategoryUtility;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AllSubCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'banner' => api_asset($data->banner),
                    'icon' => api_asset($data->icon),
                    'number_of_children' => CategoryUtility::get_immediate_children_count($data->id),
                    'links' => [
                        'products' => route('api.products.category', $data->id),
                        'sub_categories' => route('subCategories.index', $data->id)
                    ],
                    'sub_category' => [
                        new AllSubCategoryCollection(DB::table('categories')->where('parent_id', $data->id)->orderBy('order_level','ASC')->get())
                    ]
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
