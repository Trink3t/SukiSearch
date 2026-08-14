<?php

namespace Database\Seeders;

use App\Enums\StoreStatus;
use App\Enums\UserRole;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(int $count = 10): void
    {
        $owners = User::query()->whereHas('roles', fn ($query) => $query->where('name', UserRole::STORE_OWNER->value))->get();

        if ($count === 0 || $owners->isEmpty()) {
            return;
        }

        Store::factory($count)
            ->sequence(fn (Sequence $sequence): array => [
                'user_id' => $owners[$sequence->index % $owners->count()]->id,
                'name' => fake('en_PH')->company().' '.$sequence->index,
                'barangay_external_id' => fake()->bothify('PH-######').$sequence->index,
                'status' => $sequence->index % 5 === 0 ? StoreStatus::PENDING : StoreStatus::ACTIVE,
                'is_open' => $sequence->index % 6 !== 0,
            ])
            ->create();
    }
}
