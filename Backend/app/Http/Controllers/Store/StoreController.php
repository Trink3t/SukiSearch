<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreIndexRequest;
use App\Http\Resources\Store\StoreBaseResource;
use App\Http\Resources\Store\StoreResource;
use App\Models\Store;
use App\Queries\Store\StoreQuery;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct(
        private readonly StoreQuery $storeQuery
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
