<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'phonenumber' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'password' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'postal_code' => 'required',
            'country' => 'required',
            'city' => 'required',
            'province' => 'required',
        ];
    }
}
