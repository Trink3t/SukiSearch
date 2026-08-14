<?php

namespace Database\Factories;

use App\Enums\StoreOwnerEnrollmentStatus;
use App\Models\StoreOwnerEnrollment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StoreOwnerEnrollment>
 */
class StoreOwnerEnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'status' => StoreOwnerEnrollmentStatus::PENDING,
            'reviewed_by' => null,
            'reviewed_at' => null,
            'rejection_reason' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StoreOwnerEnrollmentStatus::APPROVED,
            'reviewed_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'reviewed_at' => fake()->dateTimeBetween('-14 days'),
            'rejection_reason' => null,
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StoreOwnerEnrollmentStatus::REJECTED,
            'reviewed_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'reviewed_at' => fake()->dateTimeBetween('-14 days'),
            'rejection_reason' => fake()->sentence(12),
        ]);
    }
}
