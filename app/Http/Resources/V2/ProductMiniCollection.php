<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class ProductMiniCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $photos = explode(',',$data->photos);
                if($data->discount_type == "percent"){
                    $data->discount_percent = $data->discount;
                    }
                    else{
                    $data->discount_percent = (int)round(($data->discount/$data->unit_price)*100);
                    }
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'slug' => $data->slug,
                    'thumbnail_image' => api_asset($photos[0] == 0 ? $photos[1] : $photos[0]),
                    'has_discount' => home_base_price($data, false) != home_discounted_base_price($data, false) ,
                    'stroked_price' => home_base_price($data),
                    'main_price' => home_discounted_base_price($data),
                    'discount' => $data->discount_percent,
                    'rating' => (double) $data->rating,
                    'sales' => (integer) $data->num_of_sale,
                    'links' => [
                        'details' => route('products.show', $data->id),
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
