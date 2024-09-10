<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
           'name' => 'required|string',
           'pname' => 'required|string',
           'description' => 'nullable|text',
            'email' => 'required|string|email|unique:users',
            'phone' => 'nullable|string|max:12',
            'age' => 'nullable|byte',
            'sex' => 'nullable|boolean',

        ];
    }
}
