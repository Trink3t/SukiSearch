<?php

namespace Database\Seeders;

use App\Enums\ReservationItemStatus;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Illuminate\Database\Seeder;

class ReservationItemSeeder extends Seeder
{
    public function run(): void
    {
        $rejectionReasons = ['Out of stock', 'Damaged item', 'Incorrect price', 'Store closed'];

        Reservation::query()->with('store.products')->orderBy('id')->each(function (Reservation $reservation, int $reservationIndex) use ($rejectionReasons): void {
            $products = $reservation->store->products->values();
            foreach (ReservationItemStatus::cases() as $itemIndex => $status) {
                $product = $products[$itemIndex % $products->count()];
                $requestedQuantity = 2;
                ReservationItem::query()->firstOrCreate(['reservation_id' => $reservation->id, 'product_id' => $product->id], ReservationItem::factory()->make([
                    'reservation_id' => $reservation->id, 'product_id' => $product->id, 'product_name' => $product->name,
                    'unit_price' => $product->getRawOriginal('price'), 'requested_quantity' => $requestedQuantity, 'status' => $status,
                    'accepted_quantity' => in_array($status, [ReservationItemStatus::ACCEPTED, ReservationItemStatus::READY_FOR_PICKUP, ReservationItemStatus::COMPLETED], true) ? $requestedQuantity : 0,
                    'rejection_reason' => $status === ReservationItemStatus::REJECTED ? $rejectionReasons[$reservationIndex % count($rejectionReasons)] : null,
                    'cancellation_reason' => $status === ReservationItemStatus::CANCELLED ? 'Customer cancelled the item.' : null,
                ])->getAttributes());
            }
        });
    }
}
