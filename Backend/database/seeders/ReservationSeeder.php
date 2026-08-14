<?php

namespace Database\Seeders;

use App\Enums\CancelledBy;
use App\Enums\ReservationStatus;
use App\Enums\StoreStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Reservation;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(int $count = 20, int $reviewCount = 15): void
    {
        $customers = User::query()->where('status', UserStatus::ACTIVE->value)->whereHas('roles', fn ($query) => $query->where('name', UserRole::CUSTOMER->value))->get();
        $stores = Store::query()->where('status', StoreStatus::ACTIVE->value)->where('is_open', true)->get();

        if ($count === 0 || $customers->isEmpty() || $stores->isEmpty()) {
            return;
        }

        $completedCount = min($count, $reviewCount);
        Reservation::factory($count)
            ->sequence(function (Sequence $sequence) use ($customers, $stores, $completedCount): array {
                $status = $sequence->index < $completedCount
                    ? ReservationStatus::COMPLETED
                    : ReservationStatus::cases()[($sequence->index - $completedCount) % count(ReservationStatus::cases())];
                $createdAt = fake()->dateTimeBetween('-1 month');

                return [
                    'customer_id' => $customers[$sequence->index % $customers->count()]->id,
                    'store_id' => $stores[$sequence->index % $stores->count()]->id,
                    'status' => $status,
                    'expires_at' => $status === ReservationStatus::EXPIRED ? now()->subHour() : now()->addHours(fake()->numberBetween(1, 24)),
                    'ready_at' => in_array($status, [ReservationStatus::READY_FOR_PICKUP, ReservationStatus::COMPLETED], true) ? now()->subHours(fake()->numberBetween(1, 24)) : null,
                    'picked_up_at' => $status === ReservationStatus::COMPLETED ? now()->subHour() : null,
                    'completed_at' => $status === ReservationStatus::COMPLETED ? now() : null,
                    'cancelled_by' => $status === ReservationStatus::CANCELLED ? fake()->randomElement(CancelledBy::cases()) : null,
                    'cancelled_reason' => $status === ReservationStatus::CANCELLED ? fake()->sentence(10) : null,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            })
            ->create();
    }
}
