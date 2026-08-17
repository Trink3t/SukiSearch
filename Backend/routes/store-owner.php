<?php

use App\Enums\UserRole;
use App\Http\Controllers\StoreOwner\GetStoreOwnerStoresController;
use Illuminate\Support\Facades\Route;

Route::prefix('store-owner')->middleware(['auth:sanctum', 'role:'.UserRole::STORE_OWNER->value.','.UserRole::ADMIN->value])->group(function () {
    Route::prefix('stores')->group(function () {
        Route::get('/', GetStoreOwnerStoresController::class);
    });
});
