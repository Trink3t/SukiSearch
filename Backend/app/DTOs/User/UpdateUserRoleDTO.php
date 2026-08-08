<?php

namespace App\DTOs\User;

use App\Http\Requests\User\UpdateUserRoleRequest;
use App\Models\User;

final readonly class UpdateUserRoleDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public array $roles,
        public User $user,
    ) {}

    public static function fromRequest(UpdateUserRoleRequest $request, User $user): self
    {
        return new self(
            roles: $request->validated('roles'),
            user: $user,
        );
    }
}
