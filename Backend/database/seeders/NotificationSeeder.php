<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->whereHas('roles', fn ($query) => $query->where('name', 'customer'))->each(function (User $user): void {
            Notification::query()->firstOrCreate(
                ['user_id' => $user->id, 'type' => 'reservation_status', 'title' => 'Reservation update'],
                ['body' => 'May update sa inyong reservation.', 'data' => json_encode(['source' => 'seeder'], JSON_THROW_ON_ERROR), 'read_at' => null],
            );
        });
    }
}
