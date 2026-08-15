<?php

namespace App\Services;

use App\DTOs\Store\AddStoreDTO;
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
            'city_municipality' => $dto->cityMunicipality,
            'province' => $dto->province,
            'latitude' => $dto->latitude,
            'longitude' => $dto->longitude,
        ]);

        return $store;
    }
}
