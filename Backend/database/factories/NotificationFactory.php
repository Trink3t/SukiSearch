<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 'type' => fake()->word(), 'title' => fake()->sentence(4), 'body' => fake()->sentence(12), 'data' => json_encode(['reference' => fake()->uuid()], JSON_THROW_ON_ERROR), 'read_at' => fake()->optional()->dateTimeBetween('-1 month'),
        ];
    }
}
