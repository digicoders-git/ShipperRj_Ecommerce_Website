<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Carbon\Carbon;

class Offer extends Model
{
    use HasCustomId;

    protected $fillable = [
        'category_id',
        'product_id',
        'offer_name',
        'offer_type',
        'discount_type',
        'discount_value',
        'discount_percentage',
        'start_date',
        'end_date',
        'image',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'discount_value' => 'float',
        'status' => 'integer'
    ];

    public function getTablePrefix()
    {
        return 'OFFR';
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Check if offer is currently live
     */
    public function isLive(): bool
    {
        $now = now();
        return $this->status == 1 && $this->start_date <= $now && $this->end_date >= $now;
    }

    /**
     * Check if offer is scheduled for future
     */
    public function isScheduled(): bool
    {
        return $this->start_date > now();
    }

    /**
     * Check if offer is expired
     */
    public function isExpired(): bool
    {
        return $this->end_date < now();
    }

    /**
     * Accessor for human readable status badge
     */
    public function getOfferStatusAttribute(): string
    {
        if ($this->status == 0) {
            return 'Inactive';
        }
        $now = now();
        if ($this->start_date > $now) {
            return 'Scheduled';
        }
        if ($this->end_date < $now) {
            return 'Expired';
        }
        return 'Live';
    }

    /**
     * Calculate discount amount on a base price
     */
    public function calculateDiscount($basePrice): float
    {
        $basePrice = (float) $basePrice;
        if ($basePrice <= 0) return 0;

        if ($this->discount_type === 'fixed') {
            return min($basePrice, (float) $this->discount_value);
        } else {
            // Percentage
            $val = (float) ($this->discount_value ?: $this->discount_percentage);
            return round(($basePrice * $val) / 100, 2);
        }
    }
}
