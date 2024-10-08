<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DealCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('deal_categories')->insert([
            [
                'name' => 'TRENDING',
                'slug' => 'trending',
                'description' => 'Discover the hottest deals that everyone is talking about! Stay ahead of the curve with our trending offers, updated regularly to keep you in the know.',
                'image_path' => 'assets\images\deal_categories\Trending.svg',
                'active' => 1,
            ],
            [
                'name' => 'POPULAR',
                'slug' => 'popular',
                'description' => 'Our most sought-after deals, handpicked by our community. Don’t miss out on these fan favorites that everyone loves!',
                'image_path' => 'assets\images\deal_categories\Popular.svg',
                'active' => 1,
            ],
            [
                'name' => 'EARLY BIRD',
                'slug' => 'early_bird',
                'description' => 'Be the first to grab these exclusive deals before they’re gone! Perfect for those who like to plan ahead and save early.',
                'image_path' => 'assets\images\deal_categories\Early_Bird.svg',
                'active' => 1,
            ],
            [
                'name' => 'LAST CHANCE',
                'slug' => 'last_chance',
                'description' => 'Hurry! These deals are about to expire. Don’t miss your final opportunity to snag these offers before they disappear.',
                'image_path' => 'assets\images\deal_categories\Last_Chance.svg',
                'active' => 1,
            ],
            [
                'name' => 'LIMITED TIME',
                'slug' => 'limited_time',
                'description' => 'Time-sensitive offers that won’t last long. Act fast and make the most of these limited-time savings!',
                'image_path' => 'assets\images\deal_categories\Limited_Time.svg',
                'active' => 1,
            ]
        ]);
    }
}
