<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
           'firstname' => 'required|string|max:255',  
            'lastname' => 'required|string|max:255',  
            'phonenumber' => 'required|string|max:15',
            'address' => 'required|string|max:255',  
            'position' => 'required|string|max:255',  
            'salary' => 'required|numeric|min:0',    
        ];
    }
}