<?php

namespace App\DTOs\Cart;

use App\Http\Requests\Cart\AddItemToCartRequest;

final readonly class AddItemToCartDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $product_id,
        public ?int $quantity
    ) {}

    public static function fromRequest(AddItemToCartRequest $request): self
    {
        return new self(
            product_id: $request->validated('product_id'),
            quantity: $request->validated('quantity')
        );
    }
}
