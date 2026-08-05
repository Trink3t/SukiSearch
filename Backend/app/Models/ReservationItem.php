<?php

namespace App\Models;

use App\Enums\ReservationItemStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'reservation_id',
    'product_id',
    'product_name',
    'unit_price',
    'requested_quantity',
    'accepted_quantity',
    'status',
    'rejection_reason',
    'cancellation_reason',
])]

#[Table('reservation_items')]
class ReservationItem extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => ReservationItemStatus::class,
            'unit_price' => 'decimal',
            'requested_quantity' => 'integer',
            'accepted_quantity' => 'integer',
        ];
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
