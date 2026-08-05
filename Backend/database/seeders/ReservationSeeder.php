<?php

namespace Database\Seeders;

use App\Enums\CancelledBy;
use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::query()->whereHas('roles', fn ($query) => $query->where('name', 'customer'))->orderBy('id')->get();
        $stores = Store::query()->orderBy('id')->get();

        foreach (ReservationStatus::cases() as $index => $status) {
            $store = $stores[$index % $stores->count()];
            $customer = $customers[$index % $customers->count()];
            $publicId = sprintf('00000000-0000-4000-8000-%012d', $index + 1);
            Reservation::query()->firstOrCreate(['public_id' => $publicId], Reservation::factory()->make([
                'public_id' => $publicId, 'customer_id' => $customer->id, 'store_id' => $store->id, 'status' => $status,
                'expires_at' => $status === ReservationStatus::EXPIRED ? now()->subHour() : now()->addHours(2),
                'ready_at' => in_array($status, [ReservationStatus::READY_FOR_PICKUP, ReservationStatus::COMPLETED], true) ? now()->subHour() : null,
                'picked_up_at' => $status === ReservationStatus::COMPLETED ? now()->subMinutes(30) : null,
                'completed_at' => $status === ReservationStatus::COMPLETED ? now() : null,
                'cancelled_by' => $status === ReservationStatus::CANCELLED ? CancelledBy::CUSTOMER : null,
                'cancelled_reason' => $status === ReservationStatus::CANCELLED ? 'Changed plans.' : null,
            ])->getAttributes());
        }
    }
}
