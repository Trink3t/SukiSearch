<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Queries\User\UserQuery;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserQuery $userQuery
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
