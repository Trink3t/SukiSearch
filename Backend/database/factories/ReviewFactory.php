<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Review;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(), 'customer_id' => User::factory(), 'store_id' => Store::factory(),
            'rating' => fake()->numberBetween(1, 5), 'comment' => fake()->optional()->sentence(), 'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $a) => ['published_at' => now()]);
    }
}
