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
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Collection of clothing, accessories, and trends that express personal style and cultural influences.',
                'active' => 1,
                'order' => 5,
            ],          
            [
                'name' => 'Health Care',
                'slug' => 'health_care',
                'description' => 'Group of health care-related categories, including hospitals, clinics, and medical services',
                'active' => 1,
                'order' => 6,
            ],
            [
                'name' => 'Jewellery',
                'slug' => 'jewellery',
                'description' => 'Collection of adornments and decorative items, including rings, necklaces, bracelets, and earrings.',
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
            ],
            [
                'name' => 'Others',
                'slug' => 'others',
                'description' => 'Miscellaneous categories that do not fit into other defined groups, covering a variety of topics and services.',
                'active' => 1,
                'order' => 11,
            ]
        ]);
    }
}
