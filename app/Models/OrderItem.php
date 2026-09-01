<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class OrderItem extends Model
{
    use HasCustomId;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    public function getTablePrefix()
    {
        return 'OIT';
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
