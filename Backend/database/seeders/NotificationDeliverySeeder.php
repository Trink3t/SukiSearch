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
            foreach ([NotificationDeliveryChannel::IN_APP, NotificationDeliveryChannel::EMAIL] as $index => $channel) {
                $status = [NotificationDeliveryStatus::PENDING, NotificationDeliveryStatus::SENT][$index];
                NotificationDelivery::query()->firstOrCreate(['notification_id' => $notification->id, 'channel' => $channel->value], [
                    'status' => $status->value, 'sent_at' => $status === NotificationDeliveryStatus::SENT ? now() : null,
                    'failed_at' => $status === NotificationDeliveryStatus::FAILED ? now() : null,
                    'error_message' => $status === NotificationDeliveryStatus::FAILED ? 'Temporary delivery failure.' : null,
                ]);
            }
        });
    }
}
