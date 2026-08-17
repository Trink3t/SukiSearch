<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;

class ProductPolicy
{
    public function viewAny(User $user, Store $store): bool
    {
        return $this->canManageStore($user, $store);
    }

    public function view(User $user, Product $product): bool
    {
        return $this->canManageProduct($user, $product);
    }

    public function create(User $user, Store $store): bool
    {
        return $this->canManageStore($user, $store);
    }

    public function update(User $user, Product $product): bool
    {
        return $this->canManageProduct($user, $product);
    }

    public function delete(User $user, Product $product): bool
    {
        return $this->canManageProduct($user, $product);
    }

    public function restore(User $user, Product $product): bool
    {
        return $this->canManageProduct($user, $product);
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    private function canManageStore(User $user, Store $store): bool
    {
        return $user->hasRole(UserRole::ADMIN)
            || (
                $user->hasRole(UserRole::STORE_OWNER)
                && $user->is($store->owner)
            );
    }

    private function canManageProduct(User $user, Product $product): bool
    {
        return $product->store !== null
            && $this->canManageStore($user, $product->store);
    }
}
