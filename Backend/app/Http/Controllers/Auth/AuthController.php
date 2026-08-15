<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Auth\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserBaseResource;
use App\Services\AuthService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('Auth')]
class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    /**
     * Authenticate a user and issue an API access token.
     */
    public function login(LoginRequest $request)
    {
        $dto = LoginDTO::fromRequest($request);

        $user = $this->authService->login($dto);

        $token = $user->createToken('access_token');

        return $this->successResponse(
            data: [
                'id' => $user->id,
            ],
            meta: [
                'token' => $token->plainTextToken,
            ],
            message: 'Login successful.'
        );
    }

    /**
     * Retrieve the authenticated user's profile.
     */
    public function me(Request $request)
    {
        return UserBaseResource::make($request->user());
    }

    /**
     * Revoke the current API access token.
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return $this->successResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }

    /**
     * Revoke all API access tokens for the authenticated user.
     */
    public function logoutAll(Request $request)
    {
        $this->authService->logoutAll($request);

        return $this->successResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }
}
