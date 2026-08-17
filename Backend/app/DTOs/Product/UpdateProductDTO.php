<?php

namespace App\DTOs\Product;

use App\Http\Requests\Product\UpdateProductRequest;

final readonly class UpdateProductDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?array $attributes,
    ) {}

    public static function fromRequest(UpdateProductRequest $request): self
    {
        return new self(
            attributes: $request->validated(),
        );
    }
}
