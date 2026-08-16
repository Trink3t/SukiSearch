<?php

use App\Enums\UserRole;
use App\Http\Controllers\Store\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Store\StoreController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/stores')->middleware(['auth:sanctum', 'role:'.UserRole::ADMIN->value])->group(function () {
    Route::get('/', [AdminStoreController::class, 'index']);
    Route::get('/{store}', [AdminStoreController::class, 'show']);
});

Route::prefix('/stores')->group(function () {
    Route::get('/', [StoreController::class, 'index']);
    Route::get('/{store}', [StoreController::class, 'show']);
});
