<?php

namespace App\Policies;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CartitemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CartItem $cartItem): bool
    {
        return $cartItem->user->is($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Product $product): bool|Response
    {
        $this->verifyProductAvailability($product);

        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CartItem $cartItem): bool|Response
    {
        $this->verifyProductAvailability($cartItem->product);

        return $cartItem->user->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CartItem $cartItem): bool
    {
        return $cartItem->user->is($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CartItem $cartItem): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CartItem $cartItem): bool
    {
        return false;
    }

    private function verifyProductAvailability(Product $product): Response
    {
        if (! $product->is_active) {
            return Response::deny(
                'Product is not available.'
            );
        }

        return Response::allow();
    }
}
