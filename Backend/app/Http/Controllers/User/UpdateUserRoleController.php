<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\UpdateUserRoleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRoleRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\UserService;
use Dedoc\Scramble\Attributes\Group;

#[Group('User')]
class UpdateUserRoleController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * Update the user role.
     */
    public function __invoke(UpdateUserRoleRequest $request, User $user)
    {
        $updated = $this->userService->setRoles(UpdateUserRoleDTO::fromRequest($request, $user));

        return $this->successResponse(
            data: UserResource::make($updated->refresh()->load('roles')),
            message: 'User roles updated successfully.'
        );
    }
}
