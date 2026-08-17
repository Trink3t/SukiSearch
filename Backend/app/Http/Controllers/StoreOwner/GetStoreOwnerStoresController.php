<?php

namespace App\Http\Controllers\StoreOwner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreIndexRequest;
use App\Http\Resources\Store\AdminStoreBaseResource;
use App\Queries\Store\StoreQuery;
use Dedoc\Scramble\Attributes\Group;

#[Group('Store Owner')]
class GetStoreOwnerStoresController extends Controller
{
    public function __construct(
        private readonly StoreQuery $storeQuery,
    ) {}

    /**
     * Get all stores owned by user.
     */
    public function __invoke(StoreIndexRequest $request)
    {
        $perPage = min(
            $request->integer('per_page', 15),
            100
        );
        $stores = $this->storeQuery
            ->ownedByUser($request->user())
            ->paginate($perPage)
            ->appends($request->query());

        return AdminStoreBaseResource::collection($stores)
            ->additional([
                'message' => 'Stores retrieved successfully.',
            ]);
    }
}
