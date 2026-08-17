<?php

namespace App\Http\Resources\Product\StoreOwner;

use App\Http\Resources\Product\ProductBaseResource;
use App\Http\Resources\Store\StoreBaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(
            ProductBaseResource::toArray($request),
            [
                'is_active' => $this->is_active,
                'store' => StoreBaseResource::make($this->whenLoaded('store')),
            ]
        );
    }
}
