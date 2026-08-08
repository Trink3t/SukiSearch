<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole as UserRoleEnum;
use App\Enums\UserStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
    'first_name',
    'middle_name',
    'last_name',
    'email',
    'password',
    'mobile_number',
    'status',
    'email_verified_at',
    'mobile_verified_at',
])]

#[Hidden(['password', 'remember_token'])]

#[Table('users')]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mobile_verified_at' => 'datetime',
            'status' => UserStatus::class,
            'password' => 'hashed',
        ];
    }

    public function scopeSearch(
        Builder $query,
        string $value
    ): Builder {
        return $query->where(function (Builder $query) use ($value) {
            $query
                ->where('first_name', 'ILIKE', "%{$value}%")
                ->orWhere('middle_name', 'ILIKE', "%{$value}%")
                ->orWhere('last_name', 'ILIKE', "%{$value}%")
                ->orWhere('email', 'ILIKE', "%{$value}%");
        });
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')
            ->using(UserRole::class)
            ->withTimestamps();
    }

    public function hasRole(UserRoleEnum $role): bool
    {
        return $this->roles()->where('name', $role->value)->exists();
    }

    public function hasRoles(): bool
    {
        return $this->roles()->count() > 0;
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'user_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'user_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'customer_id');
    }

    public function recordedPayments()
    {
        return $this->hasMany(Payment::class, 'recorded_by');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    public function responses()
    {
        return $this->hasMany(ReviewResponses::class, 'store_owner_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
}
