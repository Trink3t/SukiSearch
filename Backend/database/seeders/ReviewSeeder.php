<?php

namespace Database\Seeders;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        Reservation::query()->where('status', ReservationStatus::COMPLETED->value)->each(function (Reservation $reservation): void {
            Review::query()->firstOrCreate(['reservation_id' => $reservation->id], [
                'customer_id' => $reservation->customer_id, 'store_id' => $reservation->store_id, 'rating' => 5,
                'comment' => 'Mabilis at maayos kausap. Salamat po!', 'published_at' => now(),
            ]);
        });
    }
}
