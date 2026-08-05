<?php

namespace Database\Factories;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'public_id' => (string) Str::uuid(), 'customer_id' => User::factory(), 'store_id' => Store::factory(),
            'status' => ReservationStatus::PENDING, 'expires_at' => now()->addHour(),
            'pickup_code_hash' => null, 'qr_token_hash' => null, 'ready_at' => null, 'picked_up_at' => null, 'completed_at' => null,
            'cancelled_by' => null, 'cancelled_reason' => null,
        ];
    }

    public function accepted(): static
    {
        return $this->state(fn (array $a) => ['status' => ReservationStatus::ACCEPTED]);
    }

    public function partiallyAccepted(): static
    {
        return $this->state(fn (array $a) => ['status' => ReservationStatus::PARTIALLY_ACCEPTED]);
    }

    public function readyForPickup(): static
    {
        return $this->state(fn (array $a) => ['status' => ReservationStatus::READY_FOR_PICKUP, 'ready_at' => now(), 'pickup_code_hash' => hash('sha256', '123456')]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $a) => ['status' => ReservationStatus::COMPLETED, 'ready_at' => now()->subHour(), 'picked_up_at' => now()->subMinutes(30), 'completed_at' => now()]);
    }
}
