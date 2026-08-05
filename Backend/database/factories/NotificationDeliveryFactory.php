<?php

namespace Database\Factories;

use App\Enums\NotificationDeliveryChannel;
use App\Enums\NotificationDeliveryStatus;
use App\Models\Notification;
use App\Models\NotificationDelivery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NotificationDelivery>
 */
class NotificationDeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'notification_id' => Notification::factory(), 'channel' => fake()->randomElement(NotificationDeliveryChannel::cases()), 'status' => NotificationDeliveryStatus::PENDING,
            'sent_at' => null, 'failed_at' => null, 'error_message' => null,
        ];
    }
}
