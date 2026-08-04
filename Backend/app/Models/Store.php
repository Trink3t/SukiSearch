<?php

namespace App\Models;

use App\Enums\StoreStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'owner_id',
    'name',
    'description',
    'image_path',
    'barangay_external_id',
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
    protected function casts(): array
    {
        return [
            'status' => StoreStatus::class,
            'latitude' => 'decimal',
            'longitude' => 'decimal',
            'is_open' => 'boolean',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
