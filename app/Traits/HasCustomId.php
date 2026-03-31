<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasCustomId
{
    protected static function bootHasCustomId()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $prefix = $model->getTablePrefix();
                $model->{$model->getKeyName()} = $prefix . Str::upper(Str::random(6));
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function getTablePrefix()
    {
        $prefixes = [
            'categories' => 'CAT',
            'sub_categories' => 'SCAT',
            'products' => 'PRD',
            'product_prices' => 'PRC',
            'offers' => 'OFF',
            'orders' => 'ORD',
            'order_trackings' => 'TRK',
            'users' => 'USR',
            'admins' => 'ADM',
            'complaints' => 'CMP',
            'refunds' => 'REF',
            'wallet_transactions' => 'WLT',
            'wishlists' => 'WSH',
            'user_addresses' => 'ADR',
        ];

        return $prefixes[$this->getTable()] ?? 'ID';
    }
}
