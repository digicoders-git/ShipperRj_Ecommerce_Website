<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class Category extends Model
{
    use HasCustomId;

    protected $fillable = ['name', 'image'];

    public function getTablePrefix()
    {
        return 'CAT';
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, SubCategory::class, 'category_id', 'subcategory_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'category_id');
    }

    /**
     * Get active live offer for this category
     */
    public function activeLiveOffer()
    {
        $now = now();
        return $this->hasOne(Offer::class, 'category_id')
            ->where('status', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->latestOfMany();
    }

    /**
     * Helper to get current active live offer instance
     */
    public function getActiveOffer()
    {
        $now = now();
        return Offer::where('category_id', $this->id)
            ->where('status', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->latest()
            ->first();
    }
}
