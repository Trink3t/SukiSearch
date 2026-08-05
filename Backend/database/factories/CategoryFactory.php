<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Beverages', 'Snacks', 'Canned Goods', 'Instant Food', 'Rice and Grains', 'Personal Care', 'Household', 'School Supplies']),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
