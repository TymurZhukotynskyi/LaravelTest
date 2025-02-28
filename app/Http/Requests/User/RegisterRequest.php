<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:3',
                'max:40',
                Rule::unique('users', 'name')
            ],
            'phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^\+[1-9][0-9]{7,14}$/',
                Rule::unique('users', 'phone')
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 3 characters long.',
            'name.max' => 'Name cannot exceed 40 characters.',
            'name.unique' => 'This name is already taken.',
            'phone.required' => 'Phone number is required.',
            'phone.max' => 'Phone number cannot exceed 15 characters.',
            'phone.regex' => 'The phone number must start with "+" followed by a valid country code and 7-14 digits (e.g., +380123456789).',
            'phone.unique' => 'This phone number is already registered.',
        ];
    }
}
