<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasCustomId;

class Cart extends Model
{
    use HasCustomId;

    public function getTablePrefix()
    {
        return 'CRT';
    }

    protected $fillable = ['user_id', 'product_id', 'quantity', 'options'];

    /**
     * Get the user that owns the cart item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with the cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
