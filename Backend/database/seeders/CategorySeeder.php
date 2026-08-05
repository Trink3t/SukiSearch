<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Beverages', 'Snacks', 'Canned Goods', 'Instant Food', 'Rice and Grains', 'Personal Care', 'Household', 'School Supplies'] as $name) {
            Category::query()->firstOrCreate(['name' => $name], ['description' => "Everyday {$name} items for neighborhood stores."]);
        }
    }
}
