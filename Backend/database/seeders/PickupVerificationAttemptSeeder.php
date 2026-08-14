<?php

namespace Database\Seeders;

use App\Enums\PickupVerificationStatus;
use App\Enums\ReservationStatus;
use App\Models\PickupVerificationAttempt;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class PickupVerificationAttemptSeeder extends Seeder
{
    public function run(): void
    {
        Reservation::query()->where('status', ReservationStatus::COMPLETED->value)->with('store')->each(fn (Reservation $reservation) => PickupVerificationAttempt::factory()->create([
            'reservation_id' => $reservation->id,
            'verified_by' => $reservation->store->user_id,
            'status' => PickupVerificationStatus::SUCCESS,
            'failure_reason' => null,
            'attempted_at' => $reservation->completed_at,
        ]));
    }
}
