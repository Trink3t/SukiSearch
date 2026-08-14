<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(int $count = 30): void
    {
        if ($count === 0) {
            return;
        }

        $roles = Role::query()->pluck('id', 'name');
        $users = User::factory($count)
            ->active()
            ->sequence(fn (Sequence $sequence): array => [
                'email' => fake()->userName().'.'.$sequence->index.'@'.fake()->domainName(),
                'mobile_number' => '09'.fake()->numerify('######').str_pad((string) $sequence->index, 3, '0', STR_PAD_LEFT),
                'email_verified_at' => $sequence->index % 4 === 0 ? null : fake()->dateTimeBetween('-1 year'),
                'mobile_verified_at' => $sequence->index % 5 === 0 ? null : fake()->dateTimeBetween('-1 year'),
                'status' => match (true) {
                    $sequence->index !== 0 && $sequence->index % 11 === 0 => UserStatus::DELETED,
                    $sequence->index !== 0 && $sequence->index % 9 === 0 => UserStatus::SUSPENDED,
                    default => UserStatus::ACTIVE,
                },
            ])
            ->create();

        $users->each(fn (User $user) => $user->roles()->syncWithoutDetaching([$roles[UserRole::CUSTOMER->value]]));
        $users->first()->roles()->syncWithoutDetaching([$roles[UserRole::ADMIN->value]]);
    }
}
