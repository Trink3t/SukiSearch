<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'store_id' => Store::factory(),
            'category_id' => Category::factory(),
            'name' => fake()->words(fake()->numberBetween(2, 4), true),
            'description' => fake()->optional()->sentence(12),
            'image_path' => fake()->optional()->filePath(),
            'price' => fake()->randomFloat(2, 8, 500),
            'quantity' => fake()->numberBetween(0, 80),
            'is_active' => fake()->boolean(85),
            'last_updated_at' => fake()->dateTimeBetween('-3 months'),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => ['is_active' => true]);
    }

    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => ['quantity' => fake()->numberBetween(1, 5), 'is_active' => true]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => ['quantity' => 0, 'is_active' => false]);
    }
}
