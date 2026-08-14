<?php

namespace App\Http\Resources\StoreOwnerEnrollment;

use App\Http\Resources\User\UserBaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreOwnerEnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(
            StoreOwnerEnrollmentBaseResource::make($this)->toArray($request),
            [
                'user' => UserBaseResource::make($this->whenLoaded('user')),
                'reviewer' => UserBaseResource::make($this->whenLoaded('reviewer')),
                'rejection_reason' => $this->rejection_reason,
                'reviewed_at' => $this->reviewed_at,
                'updated_at' => $this->updated_at,
            ]
        );
    }
}
