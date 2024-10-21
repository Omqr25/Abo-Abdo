<?php

namespace App\Http\Requests\User;

use App\Rules\isValidContact;
use App\Rules\isValidURL;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'firstname' => 'string|min:4',
            'lastname' => 'string|min:4',
            'address' => 'string',
            'phonenumbers' => new isValidContact('users'),
            'mobilenumbers' => new isValidContact('users'),
            'socialaccounts' => new isValidURL,
        ];
    }
}
