<?php

namespace Tests\Feature;

use App\Enums\StoreStatus;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_searches_and_filters_approved_stores(): void
    {
        $matchingStore = Store::factory()->active()->open()->create([
            'name' => 'Sari Sari Store',
            'barangay_external_id' => 'PH-123',
            'barangay' => 'San Roque',
        ]);
        Store::factory()->active()->open()->create(['name' => 'Other Store']);
        Store::factory()->create([
            'name' => 'Pending Sari Store',
            'status' => StoreStatus::PENDING,
        ]);

        $response = $this->getJson('/api/stores?filter[name]=sari&filter[is_open]=1&filter[barangay_external_id]=PH-123&filter[barangay]=San%20Roque');

        $response
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $matchingStore->id)
            ->assertJsonMissingPath('data.0.distance_km');
    }

    public function test_it_only_returns_approved_stores_when_filtering_by_status(): void
    {
        $activeStore = Store::factory()->active()->create();
        Store::factory()->create(['status' => StoreStatus::PENDING]);

        $this->getJson('/api/stores?filter[status]=active')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $activeStore->id);
    }

    public function test_it_sorts_open_stores_before_closed_stores_by_nearest_distance(): void
    {
        $openStore = Store::factory()->active()->open()->create([
            'latitude' => 14.1,
            'longitude' => 123,
        ]);
        $closedStore = Store::factory()->active()->create([
            'latitude' => 14,
            'longitude' => 123,
            'is_open' => false,
        ]);

        $response = $this->getJson('/api/stores?sort=nearest&latitude=14&longitude=123');

        $response
            ->assertOk()
            ->assertJsonPath('data.0.id', $openStore->id)
            ->assertJsonPath('data.1.id', $closedStore->id)
            ->assertJsonPath('data.1.distance_km', 0);
    }

    public function test_it_supports_descending_nearest_distance_and_pagination(): void
    {
        Store::factory()->active()->open()->create([
            'latitude' => 14,
            'longitude' => 123,
        ]);
        $farStore = Store::factory()->active()->open()->create([
            'latitude' => 14.2,
            'longitude' => 123,
        ]);

        $this->getJson('/api/stores?sort=-nearest&latitude=14&longitude=123&per_page=1')
            ->assertOk()
            ->assertJsonPath('data.0.id', $farStore->id)
            ->assertJsonPath('meta.per_page', 1)
            ->assertJsonPath('meta.total', 2);
    }

    public function test_it_rejects_missing_or_invalid_nearest_coordinates(): void
    {
        $this->getJson('/api/stores?sort=nearest&latitude=91')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['latitude', 'longitude']);

        $this->getJson('/api/stores?sort=nearest&latitude=14&longitude=181')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('longitude');
    }

    public function test_it_rejects_unsupported_query_parameters_and_invalid_pagination(): void
    {
        $this->getJson('/api/stores?filter[unsupported]=value&sort=unknown&page=0&per_page=101')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['filter', 'sort', 'page', 'per_page']);
    }
}
