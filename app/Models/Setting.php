<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'facebook_link', 'instagram_link', 'twitter_link', 'youtube_link', 'office_address'];

    public static function getAllCached()
    {
        return \Illuminate\Support\Facades\Cache::remember('global_settings', 3600, function () {
            return self::all()->pluck('value', 'key')->toArray();
        });
    }
}
