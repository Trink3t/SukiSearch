<?php

namespace App\Services;

use App\DTOs\Auth\LoginDTO;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(LoginDTO $dto): User
    {
        $successLogin = Auth::attempt($dto->toArray());
        if (! $successLogin) {
            throw new AuthenticationException('Invalid credentials.');
        }

        $user = Auth::user();

        return $user;
    }

    public function logout(): void
    {
        $user = Auth::user();

        $user->currentAccessToken->delete();

    }

    public function logoutAll(): void
    {
        $user = Auth::user();

        $user->tokens()->delete();
    }

    public function register(): void
    {
        // Implement registration later.
    }
}
