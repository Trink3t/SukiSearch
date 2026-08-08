<?php

namespace App\DTOs\User;

use App\Http\Requests\User\CreateUserRequest;

final readonly class CreateUserDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $first_name,
        public string $last_name,
        public ?string $middle_name,
        public string $email,
        public string $password,
        public ?string $mobile_number,

    ) {}

    public static function fromRequest(CreateUserRequest $request): self
    {
        return new self(
            first_name: $request->validated('first_name'),
            last_name: $request->validated('last_name'),
            middle_name: $request->validated('middle_name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            mobile_number: $request->validated('mobile_number'),
        );
    }
}
