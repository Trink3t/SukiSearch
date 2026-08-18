<?php

namespace App\Http\Controllers\Product;

use App\DTOs\Product\AddProductDTO;
use App\DTOs\Product\UpdateProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\AddProductRequest;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductBaseResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Models\Store;
use App\Queries\Product\ProductQuery;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductQuery $query,
        private readonly ProductService $productService,

    ) {}

    /**
     * Get product listings.
     */
    public function index(ProductIndexRequest $request)
    {
        $perPage = min(
            $request->integer('per_page', 15),
            100
        );

        $products = $this->query
            ->active()
            ->paginate($perPage)
            ->appends($request->query());

        return ProductBaseResource::collection($products)
            ->additional([
                'message' => 'Products retrieved successfully.',
            ]);
    }

    /**
     * Add a product to a store
     */
    public function store(AddProductRequest $request, Store $store)
    {
        $this->authorize('create', [Product::class, $store]);

        $product = $this->productService->create(
            dto: AddProductDTO::fromRequest($request),
            store: $store,
        );

        return $this->successResponse(
            data: [
                'id' => $product->id,
            ],
            message: 'Product created successfully.',
            status: Response::HTTP_CREATED
        );
    }

    /**
     * Get the specified product.
     */
    public function show(Product $product)
    {
        return $this->successResponse(
            data: ProductResource::make($product->load('store')),
            message: 'Product retrieved successfully.',
        );
    }

    /**
     * Update the specified product.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $product = $this->productService->update(
            dto: UpdateProductDTO::fromRequest($request),
            product: $product,
        );

        return $this->successResponse(
            data: [
                'id' => $product->id,
            ],
            message: 'Product updated successfully.',
        );
    }

    /**
     * Delete the specified product.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $this->productService->delete($product);

        return $this->successResponse(
            status: Response::HTTP_NO_CONTENT,
        );
    }
}
