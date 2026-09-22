<?php

namespace App\Services;

use App\DTOs\Auth\LoginDTO;
use App\Enums\AuthClient;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(LoginDTO $dto, AuthClient $authClient): User
    {
        $successLogin = Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password,
        ]);
        if (! $successLogin) {
            throw new AuthenticationException('Invalid credentials.');
        }

        $user = Auth::user();

        if (! $user instanceof User) {
            throw new AuthenticationException('Invalid credentials.');
        }

        if ($authClient === AuthClient::ADMIN && ! $user->hasRole(UserRole::ADMIN)) {
            Auth::logout();

            throw new AuthenticationException('Invalid credentials.');
        }

        return $user;
    }

    public function logout(Request $request): void
    {
        $user = $request->user();

        $user->currentAccessToken->delete();

    }

    public function logoutAll(Request $request): void
    {
        $user = $request->user();

        $user->tokens()->delete();
    }

    public function register(): void
    {
        // Implement registration later.
    }
}
