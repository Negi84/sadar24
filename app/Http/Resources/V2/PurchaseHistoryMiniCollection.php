<?php

namespace App\Http\Resources\V2;

use App\Product;
use Carbon\Carbon;
use App\Models\OrderDetail;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PurchaseHistoryMiniCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $order_query = OrderDetail::where('order_id', $data->id)->get();
                $order_items = count($order_query);
                if($order_items > 0){
                $order_query = Product::where('id',$order_query[0]['product_id'])->first();
                $photos_ids = explode(',', $order_query->photos);
                return [
                    'id' => $data->id,
                    'code' => $data->code,
                    'waybill' => (int)$data->waybill,
                    'user_id' => intval($data->user_id),
                    'order_image' => api_asset($photos_ids[0]),
                    'items_quantity' => $order_items,
                    'payment_type' => ucwords(str_replace('_', ' ', $data->payment_type)) ,
                    'payment_status' => $data->payment_status,
                    'payment_status_string' => ucwords(str_replace('_', ' ', $data->payment_status)),
                    'delivery_status' => $data->delivery_status,
                    'delivery_status_string' => $data->delivery_status == 'pending'? "Order Placed" : ucwords(str_replace('_', ' ',  $data->delivery_status)),
                    'grand_total' => format_price($data->grand_total) ,
                    'date' => Carbon::createFromTimestamp($data->date)->format('d-m-Y'),
                    'links' => [
                        'details' => ''
                    ]
                ];
            }
            else{
                return [
                    'id' => $data->id,
                    'code' => $data->code,
                    'waybill' => (int)$data->waybill,
                    'user_id' => intval($data->user_id),
                    'order_image' => "",
                    'items_quantity' => $order_items,
                    'payment_type' => ucwords(str_replace('_', ' ', $data->payment_type)) ,
                    'payment_status' => $data->payment_status,
                    'payment_status_string' => ucwords(str_replace('_', ' ', $data->payment_status)),
                    'delivery_status' => $data->delivery_status,
                    'delivery_status_string' => $data->delivery_status == 'pending'? "Order Placed" : ucwords(str_replace('_', ' ',  $data->delivery_status)),
                    'grand_total' => format_price($data->grand_total) ,
                    'date' => Carbon::createFromTimestamp($data->date)->format('d-m-Y'),
                    'links' => [
                        'details' => ''
                    ]
                ];
            }
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
