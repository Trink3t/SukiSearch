<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    public function run(int $count = 25): void
    {
        $users = User::query()->whereHas('roles', fn ($query) => $query->where('name', UserRole::CUSTOMER->value))->get();
        $products = Product::query()->where('is_active', true)->where('quantity', '>', 0)->get();

        if ($count === 0 || $users->isEmpty() || $products->isEmpty()) {
            return;
        }

        $pairs = $users->crossJoin($products)->shuffle()->take($count);

        $pairs->each(fn ($pair) => CartItem::factory()->create([
            'user_id' => $pair[0]->id,
            'product_id' => $pair[1]->id,
        ]));
    }
}
