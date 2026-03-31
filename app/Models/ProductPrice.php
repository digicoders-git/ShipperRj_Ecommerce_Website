<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class ProductPrice extends Model
{
    use HasCustomId;

    protected $fillable = ['product_id', 'size', 'color', 'mrp', 'selling_price', 'stock', 'status'];

    public function getTablePrefix()
    {
        return 'PRC';
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
