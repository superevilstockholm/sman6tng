<?php

namespace App\Http\Requests\Account\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

// Models
use App\Models\Account\User;

// Enums
use App\Enums\RoleEnum;

class UpdateRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($this->route('user')->id)],
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'max:255', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
            'role' => ['required', Rule::enum(RoleEnum::class)],

            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'profile_picture' => ['sometimes', 'nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'delete_profile_picture' => ['sometimes', 'nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
