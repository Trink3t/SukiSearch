<?php

namespace App\Policies;

use App\Enums\StoreOwnerEnrollmentStatus;
use App\Enums\UserRole;
use App\Models\StoreOwnerEnrollment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StoreOwnerEnrollmentPolicy
{
    public function create(User $user): Response
    {
        if (
            ! $user->hasVerifiedEmail()
            || ! $user->mobile_verified_at
        ) {
            return Response::deny(
                'Only verified users can enroll as a store owner.'
            );
        }

        $hasActiveEnrollment = $user
            ->enrollments()
            ->whereIn('status', [
                StoreOwnerEnrollmentStatus::PENDING,
                StoreOwnerEnrollmentStatus::APPROVED,
            ])
            ->exists();

        if ($hasActiveEnrollment) {
            return Response::deny(
                'User already has a pending or approved store-owner enrollment.'
            );
        }

        if ($user->hasRole(UserRole::STORE_OWNER)) {
            return Response::deny(
                'User is already a store owner.'
            );
        }

        return Response::allow();
    }

    public function updateStatus(
        User $user,
        StoreOwnerEnrollment $enrollment
    ): Response|bool {
        if (! $user->hasRole(UserRole::ADMIN)) {
            return false;
        }

        if (
            $enrollment->status
            !== StoreOwnerEnrollmentStatus::PENDING
        ) {
            return Response::deny(
                'Only pending enrollments can be reviewed.'
            );
        }

        if ($user->id === $enrollment->user_id) {
            return Response::deny(
                'You cannot review your own enrollment.'
            );
        }

        return Response::allow();
    }
}
