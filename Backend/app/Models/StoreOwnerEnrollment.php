<?php

namespace App\Models;

use App\Enums\StoreOwnerEnrollmentStatus;
use Database\Factories\StoreOwnerEnrollmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'status',
    'reviewed_by',
    'reviewed_at',
    'rejection_reason',
])]
#[Table('store_owner_enrollments')]
class StoreOwnerEnrollment extends Model
{
    /** @use HasFactory<StoreOwnerEnrollmentFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => StoreOwnerEnrollmentStatus::class,
            'reviewed_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
