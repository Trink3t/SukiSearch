<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::query()->where('is_active', true)->where('quantity', '>', 0)->orderBy('id')->get();

        User::query()->whereHas('roles', fn ($query) => $query->where('name', 'customer'))->orderBy('id')->each(function (User $user, int $userIndex) use ($products): void {
            foreach ([0, 1] as $offset) {
                $product = $products[($userIndex * 2 + $offset) % $products->count()];
                CartItem::query()->firstOrCreate(['user_id' => $user->id, 'product_id' => $product->id], ['quantity' => $offset + 1]);
            }
        });
    }
}
