<?php

namespace App\Http\Controllers\User;

use App\DTOs\Cart\AddItemToCartDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddItemToCartRequest;
use App\Http\Resources\Cart\UserCartItemResource;
use App\Models\CartItem;
use App\Services\CartService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('User Cart')]
class UserCartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    /**
     * Get all cart items.
     */
    public function index(Request $request)
    {
        $cartItems = $request->user()->cartItems->load(['product']);

        return UserCartItemResource::collection($cartItems)
            ->additional([
                'message' => 'Cart items retrieved successfully.',
            ]);
    }

    /**
     * Add item to cart.
     */
    public function store(AddItemToCartRequest $request)
    {
        $cartItem = $this->cartService->create(AddItemToCartDTO::fromRequest($request), $request->user());

        return $this->successResponse(
            data: [
                'id' => $cartItem->id,
            ],
            message: 'Cart item added successfully.',
            status: Response::HTTP_CREATED
        );
    }

    /**
     * Get sp
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Update cart item.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cartItem = $this->cartService->update($cartItem, $validated['quantity']);

        return $this->successResponse(
            data: [
                'id' => $cartItem->id,
            ],
            message: 'Cart item updated successfully.'
        );
    }

    /**
     * Remove cart item.
     */
    public function destroy(CartItem $cartItem)
    {
        $this->cartService->delete($cartItem);

        return $this->successResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }
}
