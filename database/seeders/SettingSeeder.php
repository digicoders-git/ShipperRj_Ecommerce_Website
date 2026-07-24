<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::updateOrCreate(['key' => 'facebook_link'], ['value' => 'https://facebook.com']);
        \App\Models\Setting::updateOrCreate(['key' => 'instagram_link'], ['value' => 'https://instagram.com']);
        \App\Models\Setting::updateOrCreate(['key' => 'twitter_link'], ['value' => 'https://twitter.com']);
        \App\Models\Setting::updateOrCreate(['key' => 'youtube_link'], ['value' => 'https://youtube.com']);
        \App\Models\Setting::updateOrCreate(['key' => 'office_address'], ['value' => 'Avenue 7, New Delhi, India 110001']);
    }
}
