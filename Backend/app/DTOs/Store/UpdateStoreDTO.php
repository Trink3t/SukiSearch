<?php

namespace App\DTOs\Store;

use App\Http\Requests\Store\UpdateStoreRequest;

class UpdateStoreDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?array $attributes,
    ) {}

    public static function fromRequest(UpdateStoreRequest $request): self
    {
        return new self(
            attributes: $request->validated(),
        );
    }
}
