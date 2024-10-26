<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'current_password' => ['nullable', 'min:6', 'max:15', 'regex:/[a-zA-Z]/'],
            'password' => ['nullable', 'confirmed', 'min:6', 'max:15', 'regex:/[a-zA-Z]/'],
            'email' => ['nullable', 'email', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:11'],
            'address' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
