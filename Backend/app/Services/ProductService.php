<?php

namespace App\Services;

use App\DTOs\Product\AddProductDTO;
use App\DTOs\Product\UpdateProductDTO;
use App\Models\Product;
use App\Models\Store;

class ProductService
{
    public function create(AddProductDTO $dto, Store $store): Product
    {
        $product = $store->products()->create([
            'name' => $dto->name,
            'description' => $dto->description,
            'category_id' => $dto->category_id,
            'quantity' => $dto->quantity,
            'price' => $dto->price,
            'is_active' => $dto->is_active,
            'last_updated_at' => now(),
        ]);

        return $product;
    }

    public function update(UpdateProductDTO $dto, Product $product): Product
    {
        $product->update($dto->attributes);

        return $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
