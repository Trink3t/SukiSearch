<?php

namespace App\DTOs\Store;

use App\Http\Requests\Store\AddStoreRequest;

final readonly class AddStoreDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $name,
        public ?string $description,
        public string $barangay,
        public string $city_municipality,
        public string $province,
        public float $latitude,
        public float $longitude
    ) {}

    public static function fromRequest(AddStoreRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            description: $request->validated('description'),
            barangay: $request->validated('barangay'),
            city_municipality: $request->validated('city_municipality'),
            province: $request->validated('province'),
            latitude: $request->validated('latitude'),
            longitude: $request->validated('longitude'),
        );
    }
}
