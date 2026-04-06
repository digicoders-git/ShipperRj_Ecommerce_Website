<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerInquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'business_name',
        'business_type',
        'message',
        'status',
    ];
}
