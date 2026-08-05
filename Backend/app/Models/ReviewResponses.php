<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'review_id',
    'store_owner_id',
    'response',
])]
#[Table('review_responses')]
class ReviewResponses extends Model
{
    use HasFactory;

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }

    public function storeOwner()
    {
        return $this->belongsTo(User::class, 'store_owner_id');
    }
}
