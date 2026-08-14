<?php

namespace Database\Seeders;

use App\Enums\NotificationDeliveryChannel;
use App\Enums\NotificationDeliveryStatus;
use App\Models\Notification;
use App\Models\NotificationDelivery;
use Illuminate\Database\Seeder;

class NotificationDeliverySeeder extends Seeder
{
    public function run(): void
    {
        Notification::query()->each(function (Notification $notification): void {
            $status = fake()->randomElement(NotificationDeliveryStatus::cases());

            NotificationDelivery::factory()->create([
                'notification_id' => $notification->id,
                'channel' => fake()->randomElement(NotificationDeliveryChannel::cases()),
                'status' => $status,
                'sent_at' => $status === NotificationDeliveryStatus::SENT ? fake()->dateTimeBetween('-1 month') : null,
                'failed_at' => $status === NotificationDeliveryStatus::FAILED ? fake()->dateTimeBetween('-1 month') : null,
                'error_message' => $status === NotificationDeliveryStatus::FAILED ? fake()->sentence(10) : null,
            ]);
        });
    }
}
