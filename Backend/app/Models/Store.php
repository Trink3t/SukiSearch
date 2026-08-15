<?php

namespace App\Models;

use App\Enums\StoreStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'user_id',
    'name',
    'description',
    'image_path',
    'barangay',
    'city_municipality',
    'province',
    'latitude',
    'longitude',
    'status',
    'is_open',
])]
#[Table('stores')]
class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => StoreStatus::class,
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'is_open' => 'boolean',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'store_id');
    }
}
