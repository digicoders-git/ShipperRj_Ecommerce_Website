<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class Product extends Model
{
    use HasCustomId;

    protected $fillable = [
        'subcategory_id', 'name', 'slug', 'description', 'image', 'status',
        'sku', 'tags', 'stock_status', 'brand', 'manufacturer', 'seller_name',
        'featured', 'trending', 'return_policy', 'warranty', 'dimensions',
        'weight', 'shipping_charges', 'online_shipping_charges', 'cod_shipping_charges', 'mrp', 'selling_price', 'stock', 'minimum_order_quantity', 'size', 'color',
        'cod_advance_percent', 'return_days'
    ];
    protected $casts = [
        'return_days' => 'integer'
    ];

    public function getTablePrefix()
    {
        return 'PRD';
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function price()
    {
        return $this->hasOne(ProductPrice::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('status', 1);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
