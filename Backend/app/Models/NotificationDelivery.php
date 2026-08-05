<?php

namespace App\Models;

use App\Enums\NotificationDeliveryChannel;
use App\Enums\NotificationDeliveryStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'notification_id',
    'channel',
    'status',
    'sent_at',
    'failed_at',
    'error_message',
])]
class NotificationDelivery extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'channel' => NotificationDeliveryChannel::class,
            'sent_at' => 'datetime',
            'failed_at' => 'datetime',
            'status' => NotificationDeliveryStatus::class,
        ];
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}
