<?php

namespace App\Http\Requests\Store;

use App\Enums\StoreStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $requiresCoordinates = $this->sortsByNearestDistance();

        return [
            'filter' => ['sometimes', 'array:name,status,is_open,barangay_external_id,barangay'],
            'filter.name' => ['sometimes', 'string', 'max:150'],
            'filter.status' => ['sometimes', Rule::enum(StoreStatus::class)],
            'filter.is_open' => ['sometimes', 'boolean'],
            // 'filter.barangay_external_id' => ['sometimes', 'string', 'max:150'],
            'filter.barangay' => ['sometimes', 'string', 'max:150'],
            'sort' => ['sometimes', 'string', 'regex:/^-?(name|created_at|status|nearest)(,-?(name|created_at|status|nearest))*$/'],
            'latitude' => [Rule::requiredIf($requiresCoordinates), 'numeric', 'between:-90,90'],
            'longitude' => [Rule::requiredIf($requiresCoordinates), 'numeric', 'between:-180,180'],
            'include' => ['prohibited'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }

    private function sortsByNearestDistance(): bool
    {
        return collect(explode(',', (string) $this->input('sort')))
            ->map(fn (string $sort): string => ltrim(trim($sort), '-'))
            ->contains('nearest');
    }
}
