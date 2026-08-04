<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    use HasFactory;

    protected function casts(): array
    {
        return [
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
}
