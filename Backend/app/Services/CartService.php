<?php

namespace App\Services;

use App\DTOs\Cart\AddItemToCartDTO;
use App\Models\CartItem;
use App\Models\User;

class CartService
{
    public function create(AddItemToCartDTO $dto, User $user): CartItem
    {
        $cartItem = $user->cartItems()
            ->where('product_id', $dto->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $dto->quantity);

            return $cartItem->fresh();
        }

        return $user->cartItems()->create([
            'product_id' => $dto->product_id,
            'quantity' => $dto->quantity,
        ]);
    }

    public function update(CartItem $cartItem, int $quantity): CartItem
    {
        $cartItem->update([
            'quantity' => $quantity,
        ]);

        return $cartItem;
    }

    public function delete(CartItem $cartItem): void
    {
        $cartItem->delete();
    }
}
