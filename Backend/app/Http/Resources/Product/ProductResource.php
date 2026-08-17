<?php

namespace App\Http\Resources\Product;

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
            ProductBaseResource::make($this)->toArray($request),
            [
                'store' => StoreBaseResource::make($this->whenLoaded('store')),
            ]
        );
    }
}
