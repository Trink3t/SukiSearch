<?php

namespace Database\Seeders;

use App\Enums\StoreOwnerEnrollmentStatus;
use App\Enums\UserRole;
use App\Models\Role;
use App\Models\StoreOwnerEnrollment;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreOwnerEnrollmentSeeder extends Seeder
{
    public function run(int $count = 8, int $storeCount = 10): void
    {
        $admin = User::query()->whereHas('roles', fn ($query) => $query->where('name', UserRole::ADMIN->value))->first();
        $customers = User::query()->whereHas('roles', fn ($query) => $query->where('name', UserRole::CUSTOMER->value))->whereKeyNot($admin?->id)->take($count)->get();

        if ($admin === null || $customers->isEmpty()) {
            return;
        }

        $storeOwnerRoleId = Role::query()->where('name', UserRole::STORE_OWNER->value)->value('id');
        $approvedCount = min($customers->count(), max(1, min($storeCount, $count) - 2));

        $customers->each(function (User $customer, int $index) use ($admin, $approvedCount, $storeOwnerRoleId): void {
            $status = $index < $approvedCount
                ? StoreOwnerEnrollmentStatus::APPROVED
                : ($index % 2 === 0 ? StoreOwnerEnrollmentStatus::PENDING : StoreOwnerEnrollmentStatus::REJECTED);

            StoreOwnerEnrollment::factory()->create([
                'user_id' => $customer->id,
                'status' => $status,
                'reviewed_by' => $status === StoreOwnerEnrollmentStatus::PENDING ? null : $admin->id,
                'reviewed_at' => $status === StoreOwnerEnrollmentStatus::PENDING ? null : fake()->dateTimeBetween('-1 month'),
                'rejection_reason' => $status === StoreOwnerEnrollmentStatus::REJECTED ? fake()->sentence(12) : null,
            ]);

            if ($status === StoreOwnerEnrollmentStatus::APPROVED && $storeOwnerRoleId !== null) {
                $customer->roles()->syncWithoutDetaching([$storeOwnerRoleId]);
            }
        });
    }
}
