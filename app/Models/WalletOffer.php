<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletOffer extends Model
{
    protected $fillable = ['min_amount', 'bonus_amount', 'status'];
}
