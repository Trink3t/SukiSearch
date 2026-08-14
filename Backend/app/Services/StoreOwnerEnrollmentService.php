<?php

namespace App\Services;

use App\Enums\StoreOwnerEnrollmentStatus;
use App\Enums\UserRole;
use App\Models\StoreOwnerEnrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StoreOwnerEnrollmentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private UserService $userService,
    ) {}

    public function enrollAsStoreOwner(User $user): StoreOwnerEnrollment
    {
        $enrollment = $user->enrollments()->create([
            'status' => StoreOwnerEnrollmentStatus::PENDING,
        ]);

        return $enrollment;
    }

    public function approveEnrollment(
        StoreOwnerEnrollment $enrollment,
        User $admin
    ): StoreOwnerEnrollment {
        return DB::transaction(function () use ($enrollment, $admin) {
            $this->userService->addRole(
                $enrollment->user,
                UserRole::STORE_OWNER
            );

            $enrollment->update([
                'status' => StoreOwnerEnrollmentStatus::APPROVED,
                'reviewed_by' => $admin->id,
                'reviewed_at' => now(),
                'rejection_reason' => null,
            ]);

            return $enrollment->refresh();
        });
    }

    public function rejectEnrollment(
        StoreOwnerEnrollment $enrollment,
        User $admin,
        string $reason
    ): StoreOwnerEnrollment {
        return DB::transaction(function () use ($enrollment, $admin, $reason) {
            $enrollment->update([
                'status' => StoreOwnerEnrollmentStatus::REJECTED,
                'reviewed_by' => $admin->id,
                'reviewed_at' => now(),
                'rejection_reason' => $reason,
            ]);

            return $enrollment->refresh();
        });
    }
}
