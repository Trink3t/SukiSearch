<?php

use App\Enums\UserRole;
use App\Http\Controllers\User\UpdateUserRoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->middleware(['auth:sanctum', 'role:'.UserRole::ADMIN->value])->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::patch('/{user}', [UserController::class, 'update']);
    Route::post('/{user}/roles', UpdateUserRoleController::class);
    Route::delete('/{user}', [UserController::class, 'destroy']);
});
