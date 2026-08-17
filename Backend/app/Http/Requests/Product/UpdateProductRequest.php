<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:150'],
            'description' => ['sometimes', 'string', 'max:1500'],
            'category_id' => ['sometimes', 'integer', 'exists:categories,id'],
            'quantity' => ['sometimes', 'integer', 'min:0'],
            'price' => ['sometimes', 'decimal:0,2', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
