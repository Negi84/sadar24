<?php

namespace App\Http\Resources\V2;

use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PurchaseHistoryItemsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                $refund_section = false;
                $refund_button = false;
                $refund_label = "";
                $refund_request_status = 99;
                if ($refund_request_addon != null && $refund_request_addon->activated == 1) {
                    $refund_section = true;
                    $no_of_max_day = DB::table('categories')->where('id',$data->product->category_id)->pluck('return_policy')->first();
                    $last_refund_date = $data->created_at->addDays($no_of_max_day);
                    $today_date = \Carbon\Carbon::now();
                    if ($data->product != null &&
                        $data->product->refundable != 0 &&
                        $data->refund_request == null &&
                        $today_date <= $last_refund_date &&
                        $data->payment_status == 'paid' &&
                        $data->delivery_status == 'delivered') {
                        $refund_button = true;
                    } else if ($data->refund_request != null && $data->refund_request->refund_status == 0) {
                        $refund_label = "Pending";
                        $refund_request_status = $data->refund_request->refund_status;
                    } else if ($data->refund_request != null && $data->refund_request->refund_status == 2) {
                        $refund_label = "Rejected";
                        $refund_request_status = $data->refund_request->refund_status;
                    } else if ($data->refund_request != null && $data->refund_request->refund_status == 1) {
                        $refund_label = "Approved";
                        $refund_request_status = $data->refund_request->refund_status;
                    } else if ($data->product->refundable != 0) {
                        $refund_label = "N/A";
                    } else {
                        $refund_label = "Non-refundable";
                    }
                }
                $photos = explode(',',$data->product->photos);
                return [
                    'id' => $data->id,
                    'product_id' => $data->product->id,
                    'product_name' => $data->product->name,
                    'slug' => $data->product->slug,
                    'product_image' => api_asset($photos[0]),
                    'variation' => (string) $data->variation,
                    'price' => format_price($data->price),
                    'tax' => format_price($data->tax),
                    'shipping_cost' => format_price($data->shipping_cost),
                    'coupon_discount' => format_price($data->coupon_discount),
                    'quantity' => (int)$data->quantity,
                    'payment_type' =>ucwords(str_replace('_', ' ', $data->payment_type)),
                    'payment_status' => $data->payment_status,
                    'payment_status_string' => ucwords(str_replace('_', ' ', $data->payment_status)),
                    'delivery_status' => $data->delivery_status,
                    'delivery_status_string' => $data->delivery_status == 'pending' ? "Order Placed" : ucwords(str_replace('_', ' ', $data->delivery_status)),
                    'refund_section' => $refund_section,
                    'refund_button' => $refund_button,
                    'refund_label' => $refund_label,
                    'refund_request_status' => $refund_request_status,
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'waybill'=> (int)Order::where('id', $this->collection[0]->order_id)->pluck('waybill')->first(),
            'success' => true,
            'status' => 200
        ];
    }
}
