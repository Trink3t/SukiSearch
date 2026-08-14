<?php

namespace Database\Seeders;

use App\Enums\ReservationItemStatus;
use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Illuminate\Database\Seeder;

class ReservationItemSeeder extends Seeder
{
    public function run(): void
    {
        Reservation::query()->with(['store.products' => fn ($query) => $query->where('is_active', true)->where('quantity', '>', 0)])->each(function (Reservation $reservation): void {
            $products = $reservation->store->products;

            if ($products->isEmpty()) {
                return;
            }

            $products->random(fake()->numberBetween(1, min(3, $products->count())))->each(function ($product) use ($reservation): void {
                $requestedQuantity = fake()->numberBetween(1, min(5, $product->quantity));
                $status = match ($reservation->status) {
                    ReservationStatus::COMPLETED => ReservationItemStatus::COMPLETED,
                    ReservationStatus::READY_FOR_PICKUP => ReservationItemStatus::READY_FOR_PICKUP,
                    ReservationStatus::REJECTED => ReservationItemStatus::REJECTED,
                    ReservationStatus::CANCELLED => ReservationItemStatus::CANCELLED,
                    default => ReservationItemStatus::PENDING,
                };

                ReservationItem::factory()->create([
                    'reservation_id' => $reservation->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->getRawOriginal('price'),
                    'requested_quantity' => $requestedQuantity,
                    'accepted_quantity' => in_array($status, [ReservationItemStatus::READY_FOR_PICKUP, ReservationItemStatus::COMPLETED], true) ? $requestedQuantity : 0,
                    'status' => $status,
                    'rejection_reason' => $status === ReservationItemStatus::REJECTED ? fake()->sentence(10) : null,
                    'cancellation_reason' => $status === ReservationItemStatus::CANCELLED ? fake()->sentence(10) : null,
                ]);
            });
        });
    }
}
