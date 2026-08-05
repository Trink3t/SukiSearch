<?php

namespace Database\Seeders;

use App\Enums\FailureReason;
use App\Enums\PickupVerificationMethod;
use App\Enums\PickupVerificationStatus;
use App\Enums\ReservationStatus;
use App\Models\PickupVerificationAttempt;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class PickupVerificationAttemptSeeder extends Seeder
{
    public function run(): void
    {
        $reservation = Reservation::query()->where('status', ReservationStatus::COMPLETED->value)->with('store')->first();
        if ($reservation === null) {
            return;
        }

        foreach (PickupVerificationMethod::cases() as $method) {
            PickupVerificationAttempt::query()->firstOrCreate([
                'reservation_id' => $reservation->id, 'verified_by' => $reservation->store->user_id, 'method' => $method->value, 'status' => PickupVerificationStatus::SUCCESS->value,
            ], PickupVerificationAttempt::factory()->make([
                'reservation_id' => $reservation->id, 'verified_by' => $reservation->store->user_id, 'method' => $method,
                'status' => PickupVerificationStatus::SUCCESS, 'failure_reason' => null, 'attempted_at' => now(),
            ])->getAttributes());
        }
        foreach (FailureReason::cases() as $reason) {
            PickupVerificationAttempt::query()->firstOrCreate([
                'reservation_id' => $reservation->id, 'verified_by' => $reservation->store->user_id, 'method' => PickupVerificationMethod::PICKUP_CODE->value,
                'status' => PickupVerificationStatus::FAILED->value, 'failure_reason' => $reason->value,
            ], PickupVerificationAttempt::factory()->failed()->make([
                'reservation_id' => $reservation->id, 'verified_by' => $reservation->store->user_id, 'method' => PickupVerificationMethod::PICKUP_CODE,
                'status' => PickupVerificationStatus::FAILED, 'failure_reason' => $reason, 'attempted_at' => now(),
            ])->getAttributes());
        }
    }
}
