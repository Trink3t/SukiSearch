<?php

use App\Enums\AuthClient;
use App\Enums\UserRole;
use App\Http\Controllers\StoreOwnerEnrollment\ApproveStoreOwnerEnrollmentController;
use App\Http\Controllers\StoreOwnerEnrollment\RejectStoreOwnerEnrollmentController;
use App\Http\Controllers\StoreOwnerEnrollment\StoreOwnerEnrollmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('store-owner-enrollments')->middleware(['auth:sanctum', 'abilities:'.AuthClient::USER->value])->group(function () {
    Route::post('/', [StoreOwnerEnrollmentController::class, 'store']);
});

Route::prefix('store-owner-enrollments')->middleware(['auth:sanctum', 'abilities:'.AuthClient::ADMIN->value, 'role:'.UserRole::ADMIN->value])->group(function () {
    Route::get('/', [StoreOwnerEnrollmentController::class, 'index']);
    Route::patch('/{storeOwnerEnrollment}/approve', ApproveStoreOwnerEnrollmentController::class);
    Route::patch('/{storeOwnerEnrollment}/reject', RejectStoreOwnerEnrollmentController::class);
});

Route::get('store-owner-enrollments/{storeOwnerEnrollment}', [StoreOwnerEnrollmentController::class, 'show'])
    ->middleware('auth:sanctum');
