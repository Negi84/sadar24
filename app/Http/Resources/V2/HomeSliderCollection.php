<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Utility\CategoryUtility;

class HomeSliderCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => 1,
                    'name' => "",
                    'banner' => api_asset($data['file_name']),
                    'icon' => "",
                    'number_of_children' => 1,
                    'links' => [
                        'products' => $data['link'],
                        'sub_categories' => $data['link']
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
