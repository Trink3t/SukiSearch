<?php

use App\Enums\AuthClient;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::middleware(['auth:sanctum', 'abilities:'.AuthClient::USER->value])->group(function () {
        Route::post('/{store}', [ProductController::class, 'store']);
        Route::patch('/{product}', [ProductController::class, 'update']);
        Route::delete('/{product}', [ProductController::class, 'destroy']);
    });
});
