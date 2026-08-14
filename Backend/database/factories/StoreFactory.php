<?php

namespace Database\Factories;

use App\Enums\StoreStatus;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake('en_PH')->company(),
            'description' => fake()->optional()->sentence(15),
            'image_path' => fake()->optional()->filePath(),
            'barangay_external_id' => fake()->bothify('PH-########'),
            'barangay' => fake()->citySuffix(),
            'city_municipality' => fake('en_PH')->city(),
            'province' => fake('en_PH')->state(),
            'latitude' => fake()->randomFloat(8, 14.0, 15.0),
            'longitude' => fake()->randomFloat(8, 120.5, 122.0),
            'status' => fake()->randomElement(StoreStatus::cases()),
            'is_open' => fake()->boolean(80),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => ['status' => StoreStatus::ACTIVE]);
    }

    public function open(): static
    {
        return $this->state(fn (array $attributes) => ['is_open' => true]);
    }

    public function approved(): static
    {
        return $this->active();
    }
}
