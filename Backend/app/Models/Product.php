<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'store_id',
    'category_id',
    'name',
    'description',
    'image_path',
    'price',
    'quantity',
    'is_active',
    'last_updated_at',
])]
#[Table('products')]
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'price' => 'decimal',
            'quantity' => 'integer',
            'is_active' => 'boolean',
            'last_updated_at' => 'datetime',
        ];
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'product_id');
    }
}
