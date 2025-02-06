<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'name' => 'required|string|min:4',
            'height' => 'required|numeric|gt:0',
            'width' => 'required|numeric|gt:0',
            'depth' => 'required|numeric|gt:0',
            'length' => 'required|numeric|gt:0',
            'group_id' => 'required|exists:groups,id'
        ];
    }
}
