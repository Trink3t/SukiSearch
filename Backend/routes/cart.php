<?php

use App\Enums\AuthClient;
use App\Http\Controllers\User\UserCartController;

Route::prefix('cart')->middleware(['auth:sanctum', 'abilities:'.AuthClient::USER->value])->group(function () {
    Route::get('/', [UserCartController::class, 'index']);
    Route::post('/', [UserCartController::class, 'store']);
    Route::patch('/{cartItem}', [UserCartController::class, 'update']);
    Route::delete('/{cartItem}', [UserCartController::class, 'destroy']);
});
