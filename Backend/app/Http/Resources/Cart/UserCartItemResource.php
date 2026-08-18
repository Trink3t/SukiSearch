<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\Product\ProductBaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => ProductBaseResource::make($this->whenLoaded('product')),
            'quantity' => $this->quantity,
        ];
    }
}
