<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\DTOs\User\UpdateUserRoleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserRoleRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Queries\User\UserQuery;
use App\Services\UserService;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly UserQuery $userQuery,
        private readonly UserService $userService
    ) {}

    /**
     * Get all users.
     */
    #[QueryParameter('filter[search]', type: 'string')]
    #[QueryParameter('filter[status]', type: 'string')]
    #[QueryParameter('filter[email]', type: 'string', format: 'email')]
    #[QueryParameter('filter[role]', type: 'string')]
    #[QueryParameter('per_page', type: 'integer', example: 15)]
    #[QueryParameter('sort', type: 'string', example: '-created_at')]
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $perPage = min(
            (int) $request->input('per_page', 15),
            100
        );

        $users = $this->userQuery
            ->paginate($perPage)
            ->appends($request->query());

        return UserResource::collection($users)
            ->additional([
                'message' => 'Users retrieved successfully.',
            ]);

    }

    /**
     * Create user account.
     */
    public function store(CreateUserRequest $request)
    {
        $this->authorize('create', User::class);

        $dto = CreateUserDTO::fromRequest($request);

        $user = $this->userService->create($dto);

        return $this->successResponse(
            data: [
                'id' => $user->id,
            ],
            message: 'User created successfully.',
            status: Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return $this->successResponse(
            data: UserResource::make($user->refresh()->load('roles')),
            message: 'User retrieved successfully.'
        );
    }

    /**
     * Update the specified user.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $updated = $this->userService->update(UpdateUserDTO::fromRequest($request), $user);

        return $this->successResponse(
            data: UserResource::make($updated->refresh()->load('roles')),
            message: 'User updated successfully.'
        );
    }

    /**
     * Update the specified roles for a user.
     */
    public function updateRoles(UpdateUserRoleRequest $request, User $user)
    {
        $this->authorize('updateRoles', $user);

        $updated = $this->userService->setRoles(UpdateUserRoleDTO::fromRequest($request, $user));

        return $this->successResponse(
            data: UserResource::make($updated->refresh()->load('roles')),
            message: 'User roles updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $this->userService->delete($user);

        return $this->successResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }
}
