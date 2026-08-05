<?php

namespace Database\Factories;

use App\Enums\FailureReason;
use App\Enums\PickupVerificationMethod;
use App\Enums\PickupVerificationStatus;
use App\Models\PickupVerificationAttempt;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PickupVerificationAttempt>
 */
class PickupVerificationAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(), 'verified_by' => User::factory(), 'method' => fake()->randomElement(PickupVerificationMethod::cases()),
            'status' => PickupVerificationStatus::SUCCESS, 'failure_reason' => null, 'attempted_at' => now(), 'ip_address' => fake()->ipv4(), 'user_agent' => fake()->userAgent(),
        ];
    }

    public function failed(): static
    {
        return $this->state(fn (array $a) => ['status' => PickupVerificationStatus::FAILED, 'failure_reason' => fake()->randomElement(FailureReason::cases())]);
    }
}
