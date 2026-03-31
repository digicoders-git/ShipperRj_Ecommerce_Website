<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class Offer extends Model
{
    use HasCustomId;

    protected $fillable = ['product_id', 'offer_name', 'discount_percentage', 'image', 'status'];

    public function getTablePrefix()
    {
        return 'OFFR';
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
