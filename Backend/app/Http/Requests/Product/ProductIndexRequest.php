<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
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
        return [
            'filter' => ['sometimes', 'array:name,status,is_open,barangay_external_id,barangay'],
            'filter.name' => ['sometimes', 'string', 'max:150'],
            'filter.category_id' => ['sometimes', 'integer', 'min:1'],
            'sort' => ['sometimes', 'string', 'regex:/^-?(name|created_at|updated_at|quantity|price)(,-?(name|created_at|updated_at|quantity|price))*$/'],
            'include' => ['prohibited'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }
}
