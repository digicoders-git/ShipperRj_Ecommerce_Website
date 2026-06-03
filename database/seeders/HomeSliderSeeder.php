<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeSlider;

class HomeSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'badge' => 'Super Deal',
                'title' => 'India\'s <br><span class="text-gradient-primary">E-Shopping</span>',
                'subtitle' => 'BIG SALE <span class="text-primary fw-bold">UP TO 50% OFF</span>',
                'description' => 'Discover premium electronics, fashion, and lifestyle brands at the best prices. Experience the joy of shopping with Club India.',
                'button_text' => 'Shop Now',
                'button_url' => '/products',
                'image' => 'images/slider-1.png',
                'bg_color' => '#F4F7F9',
                'status' => 1,
                'sort_order' => 1,
            ],
            [
                'badge' => 'Hot New Collection',
                'title' => 'Quality <br><span class="text-gradient-primary">Lifestyle</span>',
                'subtitle' => null,
                'description' => 'Everything you need for your home and lifestyle. From gadgets to furniture, we\'ve got you covered.',
                'button_text' => 'Explore More',
                'button_url' => '/products',
                'image' => 'images/slider-2.png',
                'bg_color' => '#E8F9F9',
                'status' => 1,
                'sort_order' => 2,
            ]
        ];

        foreach ($sliders as $slider) {
            HomeSlider::create($slider);
        }
    }
}
