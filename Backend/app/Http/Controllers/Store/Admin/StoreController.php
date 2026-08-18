<?php

namespace App\Http\Controllers\Store\Admin;

use App\DTOs\Store\AddStoreDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\AddStoreRequest;
use App\Http\Requests\Store\StoreIndexRequest;
use App\Http\Resources\Store\AdminStoreBaseResource;
use App\Http\Resources\Store\AdminStoreResource;
use App\Models\Store;
use App\Models\User;
use App\Queries\Store\StoreQuery;
use App\Services\StoreService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    public function __construct(
        private readonly StoreQuery $storeQuery,
        private readonly StoreService $storeService,
    ) {}

    /**
     * (Admin) Get the list of stores.
     */
    public function index(StoreIndexRequest $request)
    {
        $stores = $this->storeQuery
            ->paginate($request->integer('per_page', 15))
            ->appends($request->query());

        return AdminStoreBaseResource::collection($stores)
            ->additional([
                'message' => 'Stores retrieved successfully.',
            ]);
    }

    /**
     * (Admin) Add new store for user.
     */
    public function store(AddStoreRequest $request, User $user)
    {
        $store = $this->storeService->create($user, AddStoreDTO::fromRequest($request));

        return $this->successResponse(
            data: AdminStoreResource::make($store),
            message: 'Store created successfully.',
            status: Response::HTTP_CREATED
        );
    }

    /**
     * (Admin) Get specific store
     * .
     */
    public function show(Store $store)
    {
        return $this->successResponse(
            data: AdminStoreResource::make($store->load('owner')),
            message: 'Store retrieved successfully.',
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        //
    }
}
