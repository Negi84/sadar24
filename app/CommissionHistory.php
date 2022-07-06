<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionHistory extends Model
{
    public function order() {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
	public function orderDetails() {
        return $this->hasOne(OrderDetail::class, 'id', 'order_detail_id');
    }
}
