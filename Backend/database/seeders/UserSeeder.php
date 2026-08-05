<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@kalapat.test'],
            User::factory()->make(['first_name' => 'Kalapat', 'last_name' => 'Admin'])->getAttributes(),
        );
        $customers = User::factory(4)->create();
        $owners = User::factory(3)->create();
        $hybridUser = User::query()->firstOrCreate(
            ['email' => 'maria.santos@kalapat.test'],
            User::factory()->make(['first_name' => 'Maria', 'last_name' => 'Santos'])->getAttributes(),
        );

        $roles = Role::query()->pluck('id', 'name');
        $admin->roles()->syncWithoutDetaching([$roles[UserRole::ADMIN->value]]);
        $customers->each(fn (User $user) => $user->roles()->syncWithoutDetaching([$roles[UserRole::CUSTOMER->value]]));
        $owners->each(fn (User $user) => $user->roles()->syncWithoutDetaching([$roles[UserRole::STORE_OWNER->value]]));
        $hybridUser->roles()->syncWithoutDetaching([$roles[UserRole::CUSTOMER->value], $roles[UserRole::STORE_OWNER->value]]);
    }
}
