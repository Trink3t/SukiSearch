<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Auth\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserBaseResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    /**
     * Login user.
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
     * Get logged in user.
     */
    public function me(Request $request)
    {
        return UserBaseResource::make($request->user());
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return $this->successResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }

    /**
     * Logout all user's sessions.
     */
    public function logoutAll(Request $request)
    {
        $this->authService->logoutAll($request);

        return $this->successResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }
}
