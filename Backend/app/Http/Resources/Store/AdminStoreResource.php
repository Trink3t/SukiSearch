<?php

namespace App\Http\Resources\Store;

use App\Http\Resources\User\UserBaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(
            AdminStoreBaseResource::make($this)->toArray($request),
            [
                'description' => $this->description,
                'owner' => UserBaseResource::make($this->whenLoaded('owner')),
            ]
        );
    }
}
