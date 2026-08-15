<?php

namespace App\Http\Requests\User;

use App\Enums\UserStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserIndexRequest extends FormRequest
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
            'filter' => ['sometimes', 'array:search,status,email,role'],
            'filter.search' => ['sometimes', 'string', 'max:150'],
            'filter.status' => ['sometimes', Rule::enum(UserStatus::class)],
            'filter.email' => ['sometimes', 'email', 'max:255'],
            'filter.role' => ['sometimes', 'string'],
            'sort' => ['sometimes', 'string', 'regex:/^-?(first_name|last_name|email|created_at)(,-?(first_name|last_name|email|created_at))*$/'],
            'include' => ['sometimes', 'string', 'in:roles'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }
}
