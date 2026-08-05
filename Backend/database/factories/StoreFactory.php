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
            'name' => fake()->unique()->randomElement(['Ate Nena', 'Kuya Jun', 'Nanay Lita', 'Aling Rosa']).' Sari-Sari Store',
            'description' => fake()->optional()->sentence(),
            'image_path' => fake()->optional()->passthrough('stores/store.jpg'),
            'barangay_external_id' => 'PH-'.fake()->unique()->numerify('####'),
            'barangay' => fake()->randomElement(['San Roque', 'Poblacion', 'Maligaya', 'Santa Cruz']),
            'city_municipality' => fake()->randomElement(['Calamba', 'Los Baños', 'San Pablo']),
            'province' => 'Laguna',
            'latitude' => fake()->randomFloat(8, 14.15, 14.30),
            'longitude' => fake()->randomFloat(8, 121.10, 121.30),
            'status' => StoreStatus::PENDING,
            'is_open' => true,
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
