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
            'name' => fake()->randomElement(['Coca-Cola 1.5L', 'Lucky Me Pancit Canton Chilimansi', 'Argentina Corned Beef 175g', 'Nescafé Original 3-in-1', 'Safeguard Pure White 85g']).' '.fake()->bothify('###'),
            'description' => fake()->optional()->sentence(),
            'image_path' => fake()->optional()->passthrough('products/product.jpg'),
            'price' => fake()->randomFloat(2, 10, 250),
            'quantity' => fake()->numberBetween(5, 80),
            'is_active' => true,
            'last_updated_at' => now(),
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
