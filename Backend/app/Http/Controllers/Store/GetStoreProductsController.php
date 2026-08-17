<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Resources\Product\ProductBaseResource;
use App\Models\Product;
use App\Models\Store;
use App\Queries\Product\ProductQuery;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('Store')]
class GetStoreProductsController extends Controller
{
    public function __construct(
        private readonly ProductQuery $query,
    ) {}

    /**
     * Get all products inside a store.
     */
    public function __invoke(ProductIndexRequest $request, Store $store)
    {
        $perPage = min(
            $request->integer('per_page', 15),
            100
        );

        $products = $this->query
            ->withinStore($store)
            ->paginate($perPage)
            ->appends($request->query());

        return ProductBaseResource::collection($products)
            ->additional([
                'message' => 'Products retrieved successfully.',
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
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
