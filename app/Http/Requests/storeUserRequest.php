<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeUserRequest extends FormRequest
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
        return 
        [
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:6|confirmed',
            'name'      => 'required|string',
            'phone'     => 'required|string|unique:users',
            'is_male'   => 'nullable|boolean',
            'birthdate' => 'nullable|date',
        ];
    }
}
