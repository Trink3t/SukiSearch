<?php

use App\Enums\UserRole;
use App\Http\Controllers\Store\Admin\SetStoreStatusController;
use App\Http\Controllers\Store\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Store\GetStoreProductsController;
use App\Http\Controllers\Store\StoreController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/stores')->middleware(['auth:sanctum', 'role:'.UserRole::ADMIN->value])->group(function () {
    Route::get('/', [AdminStoreController::class, 'index']);
    Route::get('/{store}', [AdminStoreController::class, 'show']);
    Route::post('/{user}', [AdminStoreController::class, 'store']);
    Route::patch('/{store}/suspend', [SetStoreStatusController::class, 'suspend']);
    Route::patch('/{store}/activate', [SetStoreStatusController::class, 'activate']);
    Route::patch('/{store}/close', [SetStoreStatusController::class, 'close']);
});

Route::prefix('/stores')->group(function () {
    Route::get('/', [StoreController::class, 'index']);
    Route::get('/{store}', [StoreController::class, 'show']);
    Route::post('/', [StoreController::class, 'store']);
    Route::patch('/{store}', [StoreController::class, 'update']);
    Route::delete('/{store}', [StoreController::class, 'destroy']);
    Route::get('/{store}/products', GetStoreProductsController::class);
});
