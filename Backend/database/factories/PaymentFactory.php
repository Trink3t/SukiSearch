<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(), 'method' => PaymentMethod::CASH, 'amount' => fake()->randomFloat(2, 50, 500),
            'recorded_by' => User::factory(), 'paid_at' => now(), 'notes' => fake()->optional()->sentence(),
        ];
    }

    public function paidCash(): static
    {
        return $this->state(fn (array $a) => ['method' => PaymentMethod::CASH, 'paid_at' => now()]);
    }
}
