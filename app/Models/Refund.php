<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class Refund extends Model
{
    use HasCustomId;

    protected $fillable = ['order_id', 'user_id', 'amount', 'status', 'reason'];

    public function getTablePrefix()
    {
        return 'RFND';
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
