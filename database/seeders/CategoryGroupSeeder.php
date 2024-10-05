<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_groups')->insert([
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Group of electronics-related categories including gadgets, appliances, and tech devices',
                'active' => 1,
                'order' => 1,
            ],
            [
                'name' => 'Restaurants',
                'slug' => 'restaurants',
                'description' => 'Group of restaurant-related categories, including dining, fast food, and cafes',
                'active' => 1,
                'order' => 2,
            ],
            [
                'name' => 'Beauty',
                'slug' => 'beauty',
                'description' => 'Group of beauty-related categories such as cosmetics, skincare, and salons',
                'active' => 1,
                'order' => 3,
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'Group of education-related categories, including courses, training, and study materials',
                'active' => 1,
                'order' => 4,
            ],
            [
                'name' => 'Groceries',
                'slug' => 'groceries',
                'description' => 'Group of grocery-related categories, including food markets and online grocery stores',
                'active' => 1,
                'order' => 5,
            ],
            [
                'name' => 'Wellness',
                'slug' => 'wellness',
                'description' => 'Group of wellness-related categories, including fitness, yoga, and holistic therapies',
                'active' => 1,
                'order' => 6,
            ],
            [
                'name' => 'Health Care',
                'slug' => 'health_care',
                'description' => 'Group of health care-related categories, including hospitals, clinics, and medical services',
                'active' => 1,
                'order' => 7,
            ],
            [
                'name' => 'Travel',
                'slug' => 'travel',
                'description' => 'Group of travel-related categories, including tourism, hotels, and transportation',
                'active' => 1,
                'order' => 8,
            ],
            [
                'name' => 'Logistics',
                'slug' => 'logistics',
                'description' => 'Group of logistics-related categories, including delivery services, warehousing, and transportation management',
                'active' => 1,
                'order' => 9,
            ],
            [
                'name' => 'Services',
                'slug' => 'services',
                'description' => 'Group of service-related categories, including professional services, maintenance, and repair',
                'active' => 1,
                'order' => 10,
            ]
        ]);
    }
}
