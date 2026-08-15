<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Queries\User\UserQuery;
use App\Services\UserService;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Symfony\Component\HttpFoundation\Response;

#[Group('User')]
class UserController extends Controller
{
    public function __construct(
        private readonly UserQuery $userQuery,
        private readonly UserService $userService
    ) {}

    /**
     * List users with optional filtering, sorting, role inclusion, and pagination.
     */
    #[QueryParameter('filter[search]', type: 'string')]
    #[QueryParameter('filter[status]', type: 'string')]
    #[QueryParameter('filter[email]', type: 'string', format: 'email')]
    #[QueryParameter('filter[role]', type: 'string')]
    #[QueryParameter('include', type: 'string', example: 'roles')]
    #[QueryParameter('page', type: 'integer', example: 1)]
    #[QueryParameter('per_page', type: 'integer', example: 15)]
    #[QueryParameter('sort', type: 'string', example: '-created_at')]
    public function index(UserIndexRequest $request)
    {
        $perPage = min(
            $request->integer('per_page', 15),
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

    #[Group('Auth')]
    /**
     * Register a user account.
     */
    public function store(CreateUserRequest $request)
    {
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
     * Retrieve a user and their assigned roles.
     */
    public function show(User $user)
    {

        return $this->successResponse(
            data: UserResource::make($user->refresh()->load('roles')),
            message: 'User retrieved successfully.'
        );
    }

    /**
     * Update a user's profile details.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $updated = $this->userService->update(UpdateUserDTO::fromRequest($request), $user);

        return $this->successResponse(
            data: UserResource::make($updated->refresh()->load('roles')),
            message: 'User updated successfully.'
        );
    }

    /**
     * Delete a user account.
     */
    public function destroy(User $user)
    {

        $this->userService->delete($user);

        return $this->successResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }
}
