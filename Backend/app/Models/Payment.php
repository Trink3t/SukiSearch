<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'reservation_id',
    'method',
    'amount',
    'recorded_by',
    'paid_at',
    'notes',
])]
#[Table('payments')]
class Payment extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'amount' => 'decimal',
            'paid_at' => 'datetime',
            'method' => PaymentMethod::class,
        ];
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
