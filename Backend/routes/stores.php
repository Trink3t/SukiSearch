<?php

use App\Http\Controllers\Store\StoreController;
use Illuminate\Support\Facades\Route;

Route::prefix('stores')->group(function () {
    Route::get('/', [StoreController::class, 'index']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/', [StoreController::class, 'store']);
    });
});
