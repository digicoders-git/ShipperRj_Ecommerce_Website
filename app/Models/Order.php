<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class Order extends Model
{
    use HasCustomId;

    protected $fillable = [
        'user_id', 'address_id', 'order_number', 'total_amount', 
        'shipping_amount', 'coupon_discount', 'coupon_code',
        'prepaid_amount', 'cod_amount', 'payment_status', 
        'order_status', 'payment_method', 'razorpay_order_id', 
        'razorpay_payment_id', 'admin_note',
        'advance_paid', 'refund_amount', 'refund_status', 'cancel_reason', 
        'return_status', 'return_reason', 'delivered_at'
    ];

    protected $casts = [
        'delivered_at' => 'datetime'
    ];

    public function getTablePrefix()
    {
        return 'ORD';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderTrackings()
    {
        return $this->hasMany(OrderTracking::class)->latest();
    }
}
