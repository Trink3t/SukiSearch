<?php

namespace Database\Seeders;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(int $count = 15): void
    {
        Reservation::query()->where('status', ReservationStatus::COMPLETED->value)->take($count)->each(function (Reservation $reservation): void {
            Review::factory()->published()->create([
                'reservation_id' => $reservation->id,
                'customer_id' => $reservation->customer_id,
                'store_id' => $reservation->store_id,
            ]);
        });
    }
}
