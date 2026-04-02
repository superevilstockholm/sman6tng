<?php

namespace App\Http\Requests\Account\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

// Enums
use App\Enums\RoleEnum;

class IndexRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'limit' => ['sometimes', 'nullable', 'integer', 'min:1', 'max:100'],
            'email' => ['sometimes', 'nullable', 'string', 'max:255'],
            'role' => ['sometimes', 'nullable', Rule::enum(RoleEnum::class)],

            'name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'limit.integer' => 'Limit harus berupa angka.',
            'limit.min' => 'Limit minimal adalah 1.',
            'limit.max' => 'Limit maksimal adalah 100.',

            'email.string' => 'Email harus berupa teks.',
            'email.max' => 'Email maksimal 255 karakter.',

            'role.enum' => 'Role yang dipilih tidak valid.',

            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'phone.string' => 'Nomor telepon harus berupa teks.',
            'phone.max' => 'Nomor telepon maksimal 255 karakter.',
        ];
    }
}
