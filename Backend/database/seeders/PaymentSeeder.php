<?php

namespace Database\Seeders;

use App\Enums\PaymentMethod;
use App\Enums\ReservationStatus;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Reservation::query()->where('status', ReservationStatus::COMPLETED->value)->with('store')->each(function (Reservation $reservation): void {
            Payment::query()->firstOrCreate(['reservation_id' => $reservation->id], [
                'method' => PaymentMethod::CASH->value, 'amount' => 120.00, 'recorded_by' => $reservation->store->user_id,
                'paid_at' => $reservation->completed_at, 'notes' => 'Cash payment received at pickup.',
            ]);
        });
    }
}
