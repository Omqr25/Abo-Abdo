<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'firstname' => 'string|max:255',  
            'lastname' => 'string|max:255',  
            'phonenumber' => 'string|max:15',
            'address' => 'string|max:255',  
            'position' => 'string|max:255',  
            'salary' => 'numeric|min:0',   
        ];
    }
}