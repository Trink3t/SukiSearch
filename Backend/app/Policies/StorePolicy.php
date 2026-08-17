<?php

namespace App\Policies;

use App\Enums\StoreStatus;
use App\Enums\UserRole;
use App\Models\Store;
use App\Models\User;

class StorePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Store $store): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Store $store): bool
    {
        return $user->hasRole(UserRole::ADMIN) || $user->is($store->owner);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Store $store): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Store $store): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Store $store): bool
    {
        return false;
    }

    public function activate(User $user, Store $store): bool
    {
        return in_array($store->status, [
            StoreStatus::PENDING,
            StoreStatus::SUSPENDED,
            StoreStatus::CLOSED,
        ], true);
    }

    public function suspend(User $user, Store $store): bool
    {
        return $store->status === StoreStatus::ACTIVE;
    }

    public function close(User $user, Store $store): bool
    {
        return in_array($store->status, [
            StoreStatus::ACTIVE,
            StoreStatus::SUSPENDED,
        ], true);
    }
}
