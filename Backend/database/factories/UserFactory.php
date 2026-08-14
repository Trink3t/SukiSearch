<?php

namespace Database\Factories;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('en_PH');

        return [
            'first_name' => $faker->firstName(),
            'middle_name' => $faker->optional()->firstName(),
            'last_name' => $faker->lastName(),
            'email' => $faker->safeEmail(),
            'mobile_number' => '09'.$faker->numerify('#########'),
            'email_verified_at' => $faker->optional(0.8)->dateTimeBetween('-1 year'),
            'mobile_verified_at' => $faker->optional(0.8)->dateTimeBetween('-1 year'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'status' => $faker->randomElement(UserStatus::cases()),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => ['status' => UserStatus::SUSPENDED]);
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => ['status' => UserStatus::ACTIVE]);
    }
}
