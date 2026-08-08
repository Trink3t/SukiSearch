<?php

namespace App\DTOs\User;

use App\Http\Requests\User\UpdateUserRequest;

final readonly class UpdateUserDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public array $attributes,
    ) {}

    public static function fromRequest(UpdateUserRequest $request): self
    {
        return new self(
            attributes: $request->validated(),
        );
    }
}
