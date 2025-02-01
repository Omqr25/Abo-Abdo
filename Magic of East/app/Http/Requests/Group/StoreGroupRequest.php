<?php

namespace App\Http\Requests\Group;

use App\Enums\ItemColor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreGroupRequest extends FormRequest
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
            'name' => 'required|string|min:2',
            'net_price' => 'required|numeric|gt:0',
            'description' => 'required|string|min:3',
            'colors' => 'required',
            'classification_id' => 'required|exists:classifications,id',
            'items' => 'array|required',
            //    'images' => 'array|required',
        ];
    }
    public function messages()
    {
        return [
            'colors.required' => 'حقل الالوان مطلوب',
            'colors.array'    => 'الالوان يجب ان تكون مصفوفة',
        ];
    }
}
