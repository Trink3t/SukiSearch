<?php

namespace App\Models;

use App\Enums\CancelledBy;
use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'public_id',
    'customer_id',
    'store_id',
    'status',
    'expires_at',
    'pickup_code_hash',
    'qr_token_hash',
    'ready_at',
    'picked_up_at',
    'completed_at',
    'cancelled_by',
    'cancelled_reason',
])]

#[Table('reservations')]
class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => ReservationStatus::class,
            'cancelled_by' => CancelledBy::class,
            'expires_at' => 'datetime',
            'ready_at' => 'datetime',
            'picked_up_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function items()
    {
        return $this->hasMany(ReservationItem::class, 'reservation_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'reservation_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reservation_id');
    }

    public function verificationAttempts()
    {
        return $this->hasMany(PickupVerificationAttempt::class, 'reservation_id');
    }
}
