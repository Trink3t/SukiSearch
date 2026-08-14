<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(int $count = 8): void
    {
        Category::factory($count)
            ->sequence(fn (Sequence $sequence): array => [
                'name' => fake()->words(fake()->numberBetween(1, 3), true).' '.$sequence->index,
            ])
            ->create();
    }
}
