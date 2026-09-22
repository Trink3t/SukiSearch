<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $userCount = 30;
        $storeCount = 10;
        $productCount = 50;
        $cartItemCount = 25;
        $reservationCount = 20;
        $reviewCount = 15;
        $notificationCount = 30;
        $enrollmentCount = 8;

        $this->call(RoleSeeder::class);
        $this->callWith(UserSeeder::class, ['count' => $userCount]);
        $this->callWith(StoreOwnerEnrollmentSeeder::class, ['count' => $enrollmentCount, 'storeCount' => $storeCount]);
        $this->call(CategorySeeder::class);
        $this->callWith(StoreSeeder::class, ['count' => $storeCount]);
        $this->callWith(ProductSeeder::class, ['count' => $productCount]);
        $this->callWith(CartItemSeeder::class, ['count' => $cartItemCount]);
        $this->callWith(ReservationSeeder::class, ['count' => $reservationCount, 'reviewCount' => $reviewCount]);
        $this->call(ReservationItemSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(PickupVerificationAttemptSeeder::class);
        $this->callWith(ReviewSeeder::class, ['count' => $reviewCount]);
        $this->call(ReviewResponseSeeder::class);
        $this->callWith(NotificationSeeder::class, ['count' => $notificationCount]);
        $this->call(NotificationDeliverySeeder::class);
    }
}
