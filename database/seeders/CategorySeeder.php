<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            // Categories for Electronics
            [
                'category_group_id' => 1,
                'name' => 'Mobile Phones',
                'slug' => 'mobile_phones',
                'description' => 'All types of smartphones, feature phones, and mobile accessories',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Laptops & Computers',
                'slug' => 'laptops_and_computers',
                'description' => 'Desktops, laptops, and related computer hardware',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Tablets',
                'slug' => 'tablets',
                'description' => 'Tablets and tablet accessories',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Television & Home Entertainment',
                'slug' => 'television_and_home_entertainment',
                'description' => 'Television sets, home theater systems, and streaming devices',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Cameras & Photography',
                'slug' => 'cameras_and_photography',
                'description' => 'Digital cameras, photography gear, and related accessories',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Audio & Headphones',
                'slug' => 'audio_and_headphones',
                'description' => 'Headphones, earphones, speakers, and audio devices',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Wearable Tech',
                'slug' => 'wearable_tech',
                'description' => 'Wearable devices such as smartwatches, fitness trackers, and more',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Gaming Consoles',
                'slug' => 'gaming_consoles',
                'description' => 'Gaming consoles, controllers, and related gaming accessories',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Smart Home Devices',
                'slug' => 'smart_home_devices',
                'description' => 'Smart home appliances, lighting, security systems, and automation devices',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Printers & Scanners',
                'slug' => 'printers_and_scanners',
                'description' => 'Printers, scanners, and related office equipment',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Networking Equipment',
                'slug' => 'networking_equipment',
                'description' => 'Routers, modems, switches, and other networking devices',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Computer Accessories',
                'slug' => 'computer_accessories',
                'description' => 'Computer peripherals such as keyboards, mice, and external storage',
                'active' => 1,
            ],
            [
                'category_group_id' => 1,
                'name' => 'Drones & Action Cameras',
                'slug' => 'drones_and_action+cameras',
                'description' => 'Drones, action cameras, and their accessories for outdoor photography',
                'active' => 1,
            ],
            // Categories for Restaurants
            [
                'category_group_id' => 2,
                'name' => 'Fine Dining',
                'slug' => 'fine_dining',
                'description' => 'Upscale dining experiences with gourmet meals and elegant settings',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'Casual Dining',
                'slug' => 'casual_dining',
                'description' => 'Relaxed dining venues offering moderately priced meals',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'Fast Food',
                'slug' => 'fast_food',
                'description' => 'Quick service restaurants offering fast and affordable meals',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'Buffets',
                'slug' => 'buffets',
                'description' => 'All you-can-eat restaurants with a variety of dishes and self-service',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'Takeout & Delivery',
                'slug' => 'takeout_and_delivery',
                'description' => 'Restaurants specializing in food for takeaway or home delivery',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'Cafes & Bakeries',
                'slug' => 'cafes_and_bakeries',
                'description' => 'Cafés serving coffee, pastries, and light meals, along with bakeries',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'Food Trucks',
                'slug' => 'food_trucks',
                'description' => 'Mobile food vendors offering a variety of meals on-the-go',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'Healthy Eating',
                'slug' => 'healthy_eating',
                'description' => 'Restaurants focused on nutritious and health-conscious meals',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'Vegetarian & Vegan',
                'slug' => 'vegetarian_and_vegan',
                'description' => 'Specializing in vegetarian and vegan meals, with plant-based options',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'Local Cuisine',
                'slug' => 'local_cuisine',
                'description' => 'Restaurants offering traditional and regional dishes from local cultures',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'International Cuisine',
                'slug' => 'international_cuisine',
                'description' => 'Restaurants serving dishes from various countries and global cuisines',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'Wine & Dine',
                'slug' => 'wine_and_dine',
                'description' => 'Dining experiences centered around fine wine and gourmet meals',
                'active' => 1,
            ],
            [
                'category_group_id' => 2,
                'name' => 'Special Events & Catering',
                'slug' => 'special_events_and_catering',
                'description' => 'Catering services for events, weddings, and special occasions',
                'active' => 1,
            ],
            // Categories for Beauty
            [
                'category_group_id' => 3,
                'name' => 'Skincare',
                'slug' => 'skincare',
                'description' => 'Products for cleansing, moisturizing, and treating the skin',
                'active' => 1,
            ],
            [
                'category_group_id' => 3,
                'name' => 'Makeup',
                'slug' => 'makeup',
                'description' => 'Cosmetics for enhancing the appearance of the face and skin',
                'active' => 1,
            ],
            [
                'category_group_id' => 3,
                'name' => 'Hair Care',
                'slug' => 'hair_care',
                'description' => 'Shampoos, conditioners, and treatments for hair maintenance',
                'active' => 1,
            ],
            [
                'category_group_id' => 3,
                'name' => 'Fragrances',
                'slug' => 'fragrances',
                'description' => 'Perfumes, colognes, and body sprays for a pleasant scent',
                'active' => 1,
            ],
            [
                'category_group_id' => 3,
                'name' => 'Body Care',
                'slug' => 'body_care',
                'description' => 'Lotions, creams, and scrubs for body hydration and care',
                'active' => 1,
            ],
            [
                'category_group_id' => 3,
                'name' => 'Nail Care',
                'slug' => 'nail_care',
                'description' => 'Manicure and pedicure products for nail health and appearance',
                'active' => 1,
            ],
            [
                'category_group_id' => 3,
                'name' => "Men's Grooming",
                'slug' => "men's_grooming",
                'description' => 'Products for shaving, beard care, and men’s personal grooming',
                'active' => 1,
            ],
            [
                'category_group_id' => 3,
                'name' => 'Beauty Tools',
                'slug' => 'beauty_tools',
                'description' => 'Tools for beauty application, such as brushes, sponges, and tweezers',
                'active' => 1,
            ],
            [
                'category_group_id' => 3,
                'name' => 'Organic & Natural Beauty',
                'slug' => 'organic_and_natural_beauty',
                'description' => 'Beauty products made with organic and natural ingredients',
                'active' => 1,
            ],
            [
                'category_group_id' => 3,
                'name' => 'Anti-Aging Products',
                'slug' => 'anti_aging_products',
                'description' => 'Skincare products aimed at reducing signs of aging such as wrinkles',
                'active' => 1,
            ],
            [
                'category_group_id' => 3,
                'name' => 'Sun Care',
                'slug' => 'sun_care',
                'description' => 'Sunscreens and after-sun products for protecting skin from UV rays',
                'active' => 1,
            ],
            [
                'category_group_id' => 3,
                'name' => 'Eyewear & Accessories',
                'slug' => 'eyewear_and_accessories',
                'description' => 'Eyewear such as sunglasses, reading glasses, and beauty-related accessories',
                'active' => 1,
            ],
            // Categories for Education
            [
                'category_group_id' => 4,
                'name' => 'Courses',
                'slug' => 'courses',
                'description' => 'Educational courses covering a wide range of subjects and skills',
                'active' => 1,
            ],
            [
                'category_group_id' => 4,
                'name' => 'Training Kits',
                'slug' => 'training_kits',
                'description' => 'Comprehensive kits for hands-on training and learning',
                'active' => 1,
            ],
            [
                'category_group_id' => 4,
                'name' => 'Study Materials',
                'slug' => 'study_materials',
                'description' => 'Books, notes, and other resources to support studying and learning',
                'active' => 1,
            ],
            [
                'category_group_id' => 4,
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Educational books and textbooks for various fields of study',
                'active' => 1,
            ],
            [
                'category_group_id' => 4,
                'name' => 'Online Courses',
                'slug' => 'online_courses',
                'description' => 'Digital courses accessible online, covering diverse topics and skills',
                'active' => 1,
            ],
            // Categories for Fashion
            [
                'category_group_id' => 5,
                'name' => "Men's Wear",
                'slug' => "men's_wear",
                'description' => 'A wide range of clothing and accessories designed for men, including formal and casual wear.',
                'active' => 1,
            ],
            [
                'category_group_id' => 5,
                'name' => "Women's Wear",
                'slug' => "women's_wear",
                'description' => 'A diverse collection of clothing and accessories for women, featuring styles for all occasions.',
                'active' => 1,
            ],
            [
                'category_group_id' => 5,
                'name' => "Kids' Wear",
                'slug' => "kids'_wear",
                'description' => 'Fashionable and comfortable clothing designed for children, suitable for various activities and occasions.',
                'active' => 1,
            ],
            [
                'category_group_id' => 5,
                'name' => 'Sports Wear',
                'slug' => 'sports_wear',
                'description' => 'Athletic clothing and accessories designed for physical activity, ensuring comfort and performance.',
                'active' => 1,
            ],
            // Categories for Health Care
            [
                'category_group_id' => 6,
                'name' => 'Vitamins & Supplements',
                'slug' => 'vitamins_and_supplements',
                'description' => 'Nutritional products designed to support overall health and well-being',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'Personal Hygiene',
                'slug' => 'personal_hygiene',
                'description' => 'Products for maintaining cleanliness and personal grooming',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'Over-the-Counter Medications',
                'slug' => 'over_the_counter_medications',
                'description' => 'Medications available without a prescription for common ailments',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'First Aid',
                'slug' => 'first_aid',
                'description' => 'Supplies and kits for treating minor injuries and emergencies',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'Fitness & Exercise',
                'slug' => 'fitness_and_exercise',
                'description' => 'Products and equipment designed to enhance physical fitness and exercise',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'Medical Devices',
                'slug' => 'medical_devices',
                'description' => 'Equipment used for medical purposes, including monitoring and diagnostic tools',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'Healthy Snacks',
                'slug' => 'healthy_snacks',
                'description' => 'Nutritious snack options that support a healthy lifestyle',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'Weight Management',
                'slug' => 'weight_management',
                'description' => 'Products and resources for maintaining a healthy weight',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'Herbal Remedies',
                'slug' => 'herbal_remedies',
                'description' => 'Natural remedies using herbs for various health concerns',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'Home Health Care',
                'slug' => 'home_health_care',
                'description' => 'Products and services to support health care at home',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'Wellness & Relaxation',
                'slug' => 'wellness_and_relaxation',
                'description' => 'Products that promote relaxation, stress relief, and overall wellness',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'Sleep Aids',
                'slug' => 'sleep_aids',
                'description' => 'Products designed to assist with sleep and improve sleep quality',
                'active' => 1,
            ],
            [
                'category_group_id' => 6,
                'name' => 'Dental Care',
                'slug' => 'dental_care',
                'description' => 'Products for maintaining oral health and hygiene',
                'active' => 1,
            ],
            // Categories for Jewellery
            [
                'category_group_id' => 7,
                'name' => 'Imitation Ornaments',
                'slug' => 'imitation_ornaments',
                'description' => 'Decorative ornaments made to resemble real jewellery, often crafted from affordable materials.',
                'active' => 1,
            ],
            [
                'category_group_id' => 7,
                'name' => 'Gold Plated Ornaments',
                'slug' => 'gold_plated_ornaments',
                'description' => 'Jewellery items that have a thin layer of gold applied over a base metal, offering an elegant look at a lower cost.',
                'active' => 1,
            ],
            [
                'category_group_id' => 7,
                'name' => 'Silver Plated Ornaments',
                'slug' => 'silver_plated_ornaments',
                'description' => 'Jewellery items that have a thin layer of silver applied over a base metal, providing a stylish and affordable alternative.',
                'active' => 1,
            ],
            // Categories for Travel
            [
                'category_group_id' => 8,
                'name' => 'Flights',
                'slug' => 'flights',
                'description' => 'Air travel options for domestic and international destinations',
                'active' => 1,
            ],
            [
                'category_group_id' => 8,
                'name' => 'Hotels',
                'slug' => 'hotels',
                'description' => 'Accommodation options ranging from budget to luxury stays',
                'active' => 1,
            ],
            [
                'category_group_id' => 8,
                'name' => 'Tours',
                'slug' => 'tours',
                'description' => 'Guided experiences to explore destinations and attractions',
                'active' => 1,
            ],
            [
                'category_group_id' => 8,
                'name' => 'Car Rentals',
                'slug' => 'car_rentals',
                'description' => 'Rental services for vehicles to explore at your own pace',
                'active' => 1,
            ],
            [
                'category_group_id' => 8,
                'name' => 'Travel Insurance',
                'slug' => 'travel_insurance',
                'description' => 'Coverage options to protect against travel-related risks',
                'active' => 1,
            ],
            // Categories for Logistics
            [
                'category_group_id' => 9,
                'name' => 'House Moving',
                'slug' => 'house_moving',
                'description' => 'Services for relocating residential properties, including packing and transportation',
                'active' => 1,
            ],
            [
                'category_group_id' => 9,
                'name' => 'Office Moving',
                'slug' => 'office_moving',
                'description' => 'Solutions for moving office equipment and supplies with minimal disruption',
                'active' => 1,
            ],
            [
                'category_group_id' => 9,
                'name' => 'Item Moving',
                'slug' => 'item_moving',
                'description' => 'Transport services for individual items, including heavy or bulky goods',
                'active' => 1,
            ],
            [
                'category_group_id' => 9,
                'name' => 'Goods Disposal',
                'slug' => 'goods_disposal',
                'description' => 'Safe and responsible removal of unwanted items and waste materials',
                'active' => 1,
            ],
            [
                'category_group_id' => 9,
                'name' => 'eCommerce Logistics',
                'slug' => 'ecommerce_logistics',
                'description' => 'Logistical support for online retail, including storage and fulfillment services',
                'active' => 1,
            ],
            [
                'category_group_id' => 9,
                'name' => 'eCommerce Delivery',
                'slug' => 'ecommerce_delivery',
                'description' => 'Delivery solutions for eCommerce orders, ensuring timely distribution to customers',
                'active' => 1,
            ],
            [
                'category_group_id' => 9,
                'name' => 'Warehouse Logistics',
                'slug' => 'warehouse_logistics',
                'description' => 'Management and operations of storage facilities for inventory and goods',
                'active' => 1,
            ],
            [
                'category_group_id' => 9,
                'name' => 'Global Logistics',
                'slug' => 'global_logistics',
                'description' => 'International shipping and freight forwarding services across borders',
                'active' => 1,
            ],
            // Categories for Services
            [
                'category_group_id' => 10,
                'name' => 'Electrician',
                'slug' => 'electrician',
                'description' => 'Professional electrical services including installations, repairs, and maintenance',
                'active' => 1,
            ],
            [
                'category_group_id' => 10,
                'name' => 'Plumber',
                'slug' => 'plumber',
                'description' => 'Expert plumbing services for repairs, installations, and drainage solutions',
                'active' => 1,
            ],
            [
                'category_group_id' => 10,
                'name' => 'Water Supply',
                'slug' => 'water_supply',
                'description' => 'Services related to the supply and management of water resources',
                'active' => 1,
            ],
            // Categories for Others
            [
                'category_group_id' => 11,
                'name' => 'General',
                'slug' => 'general',
                'description' => 'Broad range of miscellaneous services that do not fall into specific categories, including general repairs and maintenance.',
                'active' => 1,
            ]
        ]);
    }
}
