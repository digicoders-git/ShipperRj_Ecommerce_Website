<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'facebook_link', 'instagram_link', 'twitter_link', 'youtube_link', 'office_address'];

    private static $requestCache = null;

    public static function clearRequestCache()
    {
        self::$requestCache = null;
        Cache::forget('global_settings');
    }

    public static function getAllCached()
    {
        if (self::$requestCache !== null) {
            return self::$requestCache;
        }

        self::$requestCache = Cache::remember('global_settings', 3600, function () {
            return self::all()->pluck('value', 'key')->toArray();
        });

        return self::$requestCache;
    }

    public static function getTierShippingPercentage($price, $type = 'online', array $settingsData = [])
    {
        if (empty($settingsData)) {
            $settingsData = self::getAllCached();
        }

        $key = ($type === 'cod') ? 'shipping_tiers_cod' : 'shipping_tiers_online';
        $tiersJson = $settingsData[$key] ?? null;

        if ($tiersJson) {
            $tiers = is_array($tiersJson) ? $tiersJson : json_decode($tiersJson, true);
            if (is_array($tiers) && !empty($tiers)) {
                foreach ($tiers as $tier) {
                    $min = (float) ($tier['min_price'] ?? 0);
                    $max = ($tier['max_price'] !== null && $tier['max_price'] !== '') ? (float) $tier['max_price'] : null;
                    $pct = (float) ($tier['shipping_percent'] ?? 0);

                    if ($price >= $min && ($max === null || $price <= $max)) {
                        return $pct;
                    }
                }
            }
        }

        // Legacy fallback if no tiers match
        $fallbackKey = ($type === 'cod') ? 'global_cod_shipping' : 'global_online_shipping';
        return ($settingsData[$fallbackKey] ?? '') !== '' ? (float) $settingsData[$fallbackKey] : 0;
    }
}
