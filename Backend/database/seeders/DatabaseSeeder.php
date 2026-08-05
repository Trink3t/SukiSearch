<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            StoreSeeder::class,
            ProductSeeder::class,
            CartItemSeeder::class,
            ReservationSeeder::class,
            ReservationItemSeeder::class,
            PaymentSeeder::class,
            PickupVerificationAttemptSeeder::class,
            NotificationSeeder::class,
            NotificationDeliverySeeder::class,
            ReviewSeeder::class,
            ReviewResponseSeeder::class,
        ]);
    }
}
