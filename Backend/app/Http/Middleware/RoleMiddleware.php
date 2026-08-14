<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        $user = $request->user();

        $hasRole = $user && collect($roles)->contains(function (string $role) use ($user) {
            $enumRole = UserRole::tryFrom($role);

            return $enumRole && $user->hasRole($enumRole);
        });

        abort_unless(
            $hasRole,
            403,
            'Unauthorized action.'
        );

        return $next($request);
    }
}
