<?php

namespace App\Models;

use App\Seller;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LedgerExport
 *
 * @property int $id
 * @property int|null $seller_id
 * @property int|null $guest_id
 * @property string|null $shipping_address
 * @property string|null $payment_type
 * @property string|null $payment_status
 * @property string|null $payment_details
 * @property float|null $grand_total
 * @property float $coupon_discount
 * @property string|null $code
 * @property int $date
 * @property int $viewed
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport whereCouponDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport whereGuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport wherePaymentDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport whereShippingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LedgerExport whereViewed($value)
 * @mixin \Eloquent
 */

class LedgerExport extends Model
{
    protected $guarded = [];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

	public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
