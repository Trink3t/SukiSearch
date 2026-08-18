<?php

namespace App\Http\Controllers\Store;

use App\DTOs\Store\AddStoreDTO;
use App\DTOs\Store\UpdateStoreDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\AddStoreRequest;
use App\Http\Requests\Store\StoreIndexRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Http\Resources\Store\StoreBaseResource;
use App\Http\Resources\Store\StoreResource;
use App\Models\Store;
use App\Queries\Store\StoreQuery;
use App\Services\StoreService;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    public function __construct(
        private readonly StoreQuery $storeQuery,
        private readonly StoreService $storeService,
    ) {}

    /**
     * Get the list of stores.
     */
    public function index(StoreIndexRequest $request)
    {
        $perPage = min(
            $request->integer('per_page', 15),
            100
        );
        $stores = $this->storeQuery
            ->approved()
            ->paginate($perPage)
            ->appends($request->query());

        return StoreBaseResource::collection($stores)
            ->additional([
                'message' => 'Stores retrieved successfully.',
            ]);
    }

    /**
     * Add new store.
     */
    public function store(AddStoreRequest $request)
    {
        $store = $this->storeService->create($request->user(), AddStoreDTO::fromRequest($request));

        return $this->successResponse(
            data: StoreResource::make($store),
            message: 'Store created successfully.',
            status: Response::HTTP_CREATED
        );
    }

    /**
     * Get specific store.
     */
    public function show(Store $store)
    {
        return $this->successResponse(
            data: StoreResource::make($store->load('owner')),
            message: 'Store retrieved successfully.',
        );
    }

    /**
     * Update basic store details
     */
    public function update(UpdateStoreRequest $request, Store $store)
    {
        $store = $this->storeService->update(UpdateStoreDTO::fromRequest($request), $store);

        return $this->successResponse(
            data: StoreResource::make($store),
            message: 'Store updated successfully.',
        );
    }

    /**
     * Remove specific store
     */
    public function destroy(Store $store)
    {
        $this->storeService->delete($store);

        return $this->successResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }
}
