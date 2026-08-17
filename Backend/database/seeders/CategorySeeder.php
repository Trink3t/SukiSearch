<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Rice and Grains',
                'description' => 'Rice, corn, oats, and other grains.',
            ],
            [
                'name' => 'Canned Goods',
                'description' => 'Canned meat, fish, vegetables, and fruits.',
            ],
            [
                'name' => 'Instant Food',
                'description' => 'Instant noodles, pasta, and ready-to-cook meals.',
            ],
            [
                'name' => 'Beverages',
                'description' => 'Soft drinks, bottled water, juice, coffee, and tea.',
            ],
            [
                'name' => 'Snacks',
                'description' => 'Chips, biscuits, candies, chocolates, and other snacks.',
            ],
            [
                'name' => 'Condiments and Seasonings',
                'description' => 'Soy sauce, vinegar, salt, sugar, spices, and sauces.',
            ],
            [
                'name' => 'Personal Care',
                'description' => 'Soap, shampoo, toothpaste, deodorant, and hygiene products.',
            ],
            [
                'name' => 'Household Supplies',
                'description' => 'Laundry products, cleaning supplies, batteries, and other essentials.',
            ],
            [
                'name' => 'Baby Products',
                'description' => 'Diapers, baby food, wipes, and baby-care products.',
            ],
            [
                'name' => 'Medicine and Health',
                'description' => 'Over-the-counter medicine, vitamins, and basic health products.',
            ],
            [
                'name' => 'Frozen and Fresh Foods',
                'description' => 'Frozen meat, fish, vegetables, and other fresh food products.',
            ],
            [
                'name' => 'School and Office Supplies',
                'description' => 'Paper, pens, notebooks, envelopes, and basic school supplies.',
            ],
            [
                'name' => 'Tobacco and Accessories',
                'description' => 'Cigarettes, lighters, and related accessories.',
            ],
            [
                'name' => 'Others',
                'description' => 'Products that do not belong to the listed categories.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
