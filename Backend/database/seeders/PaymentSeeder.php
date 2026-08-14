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
        Reservation::query()->where('status', ReservationStatus::COMPLETED->value)->with(['items', 'store'])->each(function (Reservation $reservation): void {
            Payment::factory()->paidCash()->create([
                'reservation_id' => $reservation->id,
                'method' => PaymentMethod::CASH,
                'amount' => $reservation->items->sum(fn ($item) => (float) $item->getRawOriginal('unit_price') * $item->accepted_quantity),
                'recorded_by' => $reservation->store->user_id,
                'paid_at' => $reservation->completed_at,
                'notes' => fake()->optional()->sentence(10),
            ]);
        });
    }
}
