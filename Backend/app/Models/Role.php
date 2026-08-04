<?php

namespace App\Models;

use App\Enums\UserRole as RoleUser;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]

#[Table('roles')]
class Role extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'name' => RoleUser::class,
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id')
            ->using(UserRole::class)
            ->withTimestamps();
    }
}
