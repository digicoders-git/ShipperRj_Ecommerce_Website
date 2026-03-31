<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class Wishlist extends Model
{
    use HasCustomId;

    protected $fillable = ['user_id', 'product_id'];

    public function getTablePrefix()
    {
        return 'WSH';
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
