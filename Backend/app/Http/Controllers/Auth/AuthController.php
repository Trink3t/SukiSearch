<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Services\AuthService;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function login(LoginRequest $request)
    {
        $dto = $request->toDTO();

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

    public function me()
    {
        return UserResource::make(Auth::user());
    }

    public function logout()
    {
        $this->authService->logout();

        return $this->successResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }

    public function logoutAll()
    {
        $this->authService->logoutAll();

        return $this->successResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }
}
