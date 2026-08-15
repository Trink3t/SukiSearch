<?php

namespace Tests\Feature;

use App\Enums\StoreOwnerEnrollmentStatus;
use App\Enums\UserRole;
use App\Models\Role;
use App\Models\StoreOwnerEnrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_user_index_accepts_supported_query_parameters(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->active()->create();

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/users?filter[email]='.urlencode($user->email).'&include=roles&sort=first_name&page=1&per_page=1')
            ->assertOk()
            ->assertJsonPath('data.0.id', $user->id)
            ->assertJsonPath('meta.per_page', 1);
    }

    public function test_the_user_index_rejects_invalid_query_parameters(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/users?filter[unsupported]=value&sort=unknown&page=0')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['filter', 'sort', 'page']);
    }

    public function test_the_store_owner_enrollment_index_validates_its_query_parameters(): void
    {
        $user = User::factory()->active()->create();
        $enrollment = StoreOwnerEnrollment::factory()->create([
            'user_id' => $user->id,
            'status' => StoreOwnerEnrollmentStatus::PENDING,
        ]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/store-owner-enrollments?filter[status]=pending&sort=created_at&page=1&per_page=1')
            ->assertOk()
            ->assertJsonPath('data.0.id', $enrollment->id)
            ->assertJsonPath('meta.per_page', 1);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/store-owner-enrollments?filter[unsupported]=value&sort=unknown&page=0')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['filter', 'sort', 'page']);
    }

    private function createAdmin(): User
    {
        $admin = User::factory()->active()->create();
        $role = Role::query()->create(['name' => UserRole::ADMIN]);

        $admin->roles()->attach($role);

        return $admin;
    }
}
