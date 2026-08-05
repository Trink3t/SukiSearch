<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'reservation_id',
    'verified_by',
    'method',
    'status',
    'failure_reason',
    'attempted_at',
    'ip_address',
    'user_agent',
])]
#[Table('pickup_verification_attempts')]
class PickupVerificationAttempt extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'attempted_at' => 'timestamp',
        ];
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
