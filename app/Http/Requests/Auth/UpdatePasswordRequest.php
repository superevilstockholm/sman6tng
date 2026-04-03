<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'old_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'max:255', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/']
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'Password lama wajib diisi.',
            'old_password.current_password' => 'Password lama tidak sesuai.',

            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.string' => 'Password baru harus berupa teks.',
            'new_password.min' => 'Password baru minimal :min karakter.',
            'new_password.max' => 'Password baru maksimal :max karakter.',
            'new_password.regex' => 'Password baru harus mengandung huruf kecil, huruf besar, angka, dan simbol.',
        ];
    }
}
