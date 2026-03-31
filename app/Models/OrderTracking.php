<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class OrderTracking extends Model
{
    use HasCustomId;

    protected $fillable = ['order_id', 'status', 'message'];

    public function getTablePrefix()
    {
        return 'TRK';
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
