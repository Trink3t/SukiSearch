<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'description',
])]
#[Table('categories')]
class Category extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
