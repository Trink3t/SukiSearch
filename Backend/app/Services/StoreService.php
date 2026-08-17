<?php

namespace App\Services;

use App\DTOs\Store\AddStoreDTO;
use App\DTOs\Store\UpdateStoreDTO;
use App\Enums\StoreStatus;
use App\Models\Store;
use App\Models\User;

class StoreService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user, AddStoreDTO $dto): Store
    {
        $store = $user->stores()->create([
            'name' => $dto->name,
            'description' => $dto->description,
            'barangay' => $dto->barangay,
            'city_municipality' => $dto->city_municipality,
            'province' => $dto->province,
            'latitude' => $dto->latitude,
            'longitude' => $dto->longitude,
        ]);

        return $store;
    }

    public function update(UpdateStoreDTO $dto, Store $store): Store
    {
        $store->update($dto->attributes);

        return $store;
    }

    public function delete(Store $store): void
    {
        $store->delete();
    }

    public function suspend(Store $store): Store
    {
        return $this->setStatus($store, StoreStatus::SUSPENDED);
    }

    public function activate(Store $store): Store
    {
        return $this->setStatus($store, StoreStatus::ACTIVE);
    }

    public function close(Store $store): Store
    {
        return $this->setStatus($store, StoreStatus::CLOSED);
    }

    private function setStatus(Store $store, StoreStatus $status): Store
    {
        $store->update([
            'status' => $status,
        ]);

        return $store;
    }
}
