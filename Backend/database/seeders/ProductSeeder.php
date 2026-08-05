<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::query()->pluck('id', 'name');
        $products = [
            ['Lucky Me Pancit Canton Chilimansi', 'Instant Food', 18.50, 20, true], ['Coca-Cola 1.5L', 'Beverages', 78.00, 3, true],
            ['Surf Detergent Bar', 'Household', 12.00, 0, false], ['Argentina Corned Beef 175g', 'Canned Goods', 46.00, 18, true],
            ['Bear Brand Fortified Milk 33g', 'Beverages', 15.00, 25, true], ['SkyFlakes Crackers', 'Snacks', 9.00, 4, true],
            ['Safeguard Pure White 85g', 'Personal Care', 42.00, 12, true], ['Milo Powder 30g', 'Beverages', 14.00, 0, false],
        ];

        Store::query()->orderBy('id')->each(function (Store $store, int $storeIndex) use ($categories, $products): void {
            foreach ($products as $productIndex => [$name, $category, $price, $quantity, $isActive]) {
                Product::query()->firstOrCreate(['store_id' => $store->id, 'name' => $name], Product::factory()->make([
                    'store_id' => $store->id, 'category_id' => $categories[$category], 'name' => $name,
                    'description' => "{$name} available at {$store->name}.", 'price' => $price + ($storeIndex * 0.50),
                    'quantity' => $quantity, 'is_active' => $isActive, 'last_updated_at' => now(),
                ])->getAttributes());
            }
        });
    }
}
