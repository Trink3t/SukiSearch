<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(int $count = 50): void
    {
        $stores = Store::query()->where('is_open', true)->get();
        $categories = Category::query()->get();

        if ($count === 0 || $stores->isEmpty() || $categories->isEmpty()) {
            return;
        }

        Product::factory($count)
            ->sequence(fn (Sequence $sequence): array => [
                'store_id' => $stores[$sequence->index % $stores->count()]->id,
                'category_id' => $categories[$sequence->index % $categories->count()]->id,
                'name' => fake()->words(fake()->numberBetween(2, 4), true).' '.$sequence->index,
                'quantity' => $sequence->index % 8 === 0 ? 0 : fake()->numberBetween(1, 80),
                'is_active' => $sequence->index % 8 !== 0,
            ])
            ->create();
    }
}
