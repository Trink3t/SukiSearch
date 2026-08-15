<?php

use App\Http\Controllers\StoreOwnerEnrollment\ApproveStoreOwnerEnrollmentController;
use App\Http\Controllers\StoreOwnerEnrollment\RejectStoreOwnerEnrollmentController;
use App\Http\Controllers\StoreOwnerEnrollment\StoreOwnerEnrollmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('store-owner-enrollments')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [StoreOwnerEnrollmentController::class, 'index']);
    Route::post('/', [StoreOwnerEnrollmentController::class, 'store']);
    Route::get('/{storeOwnerEnrollment}', [StoreOwnerEnrollmentController::class, 'show']);
    Route::patch('/{storeOwnerEnrollment}/approve', ApproveStoreOwnerEnrollmentController::class);
    Route::patch('/{storeOwnerEnrollment}/reject', RejectStoreOwnerEnrollmentController::class);
});
