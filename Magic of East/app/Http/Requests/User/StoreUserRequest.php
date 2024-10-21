<?php

namespace App\Http\Requests\User;

use App\Rules\isValidContact;
use App\Rules\isValidURL;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'firstname' => 'required|string|min:3',
            'lastname' => 'required|string|min:3',
            'email' => 'required|email|string|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'address' => 'string',
            'phonenumbers' => new isValidContact('users'),
            'mobilenumbers' => new isValidContact('users'),
            'socialaccounts' => new isValidURL,
        ];
    }
}
