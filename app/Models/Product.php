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
        'cod_advance_percent', 'return_days', 'wholesale_prices'
    ];
    protected $casts = [
        'return_days' => 'integer',
        'wholesale_prices' => 'array'
    ];

    /**
     * Get selling price based on quantity (wholesale tiered pricing)
     */
    public function getSellingPriceForQuantity($quantity = 1): float
    {
        $price = (float) $this->selling_price;
        
        if (empty($this->wholesale_prices) || !is_array($this->wholesale_prices)) {
            return $price;
        }

        // Sort wholesale prices by min_qty descending to check highest tier first
        $tiers = $this->wholesale_prices;
        usort($tiers, function ($a, $b) {
            return $b['min_qty'] <=> $a['min_qty'];
        });

        foreach ($tiers as $tier) {
            if ($quantity >= (int)$tier['min_qty']) {
                return (float)$tier['price'];
            }
        }

        return $price;
    }

    /**
     * Get active live offer for the category this product belongs to
     */
    public function getActiveCategoryOffer()
    {
        $categoryId = $this->subCategory->category_id ?? null;
        if (!$categoryId) {
            return null;
        }

        $now = now();
        return Offer::where('category_id', $categoryId)
            ->where('status', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->latest()
            ->first();
    }

    /**
     * Get final effective selling price after applying quantity pricing AND active category offer
     */
    public function getEffectivePrice($quantity = 1): float
    {
        $basePrice = $this->getSellingPriceForQuantity($quantity);
        $offer = $this->getActiveCategoryOffer();
        if ($offer) {
            $discount = $offer->calculateDiscount($basePrice);
            return max(0, round($basePrice - $discount, 2));
        }
        return round($basePrice, 2);
    }

    /**
     * Get discount amount saved via active category offer
     */
    public function getCategoryOfferDiscountAmount($quantity = 1): float
    {
        $basePrice = $this->getSellingPriceForQuantity($quantity);
        $offer = $this->getActiveCategoryOffer();
        if ($offer) {
            return $offer->calculateDiscount($basePrice);
        }
        return 0;
    }

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
