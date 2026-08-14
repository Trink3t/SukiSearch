<?php

namespace Database\Factories;

use App\Enums\ReservationItemStatus;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReservationItem>
 */
class ReservationItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(), 'product_id' => Product::factory(), 'product_name' => fake()->words(3, true),
            'unit_price' => fake()->randomFloat(2, 8, 500), 'requested_quantity' => fake()->numberBetween(1, 5), 'accepted_quantity' => 0, 'status' => ReservationItemStatus::PENDING,
            'rejection_reason' => null, 'cancellation_reason' => null,
        ];
    }

    public function accepted(): static
    {
        return $this->state(fn (array $a) => ['status' => ReservationItemStatus::ACCEPTED, 'accepted_quantity' => $a['requested_quantity']]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $a) => ['status' => ReservationItemStatus::REJECTED, 'accepted_quantity' => 0, 'rejection_reason' => fake()->sentence()]);
    }
}
