<?php

namespace App\DTOs\Product;

use App\Http\Requests\Product\AddProductRequest;

final readonly class AddProductDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $name,
        public ?string $description,
        public int $category_id,
        public ?int $quantity,
        public float $price,
        public ?bool $is_active,
    ) {}

    public static function fromRequest(AddProductRequest $request): self
    {
        return new self(
            name: $request->name,
            description: $request->description,
            category_id: $request->category_id,
            quantity: $request->quantity,
            price: $request->price,
            is_active: $request->is_active,
        );
    }
}
