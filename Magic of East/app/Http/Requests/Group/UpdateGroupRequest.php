<?php

namespace App\Http\Requests\Group;

use App\Enums\ItemColor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateGroupRequest extends FormRequest
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
            'name' => 'string|min:4',
            'net_price' => 'numeric|gt:0',
            'description' => 'string|min:3',
            'colors' => 'array',
            'colors.*' => 'integer|in:' . implode(',', array_column(ItemColor::cases(), 'value')),
            'classification_id' => 'exists:classifications,id',
            'images' => 'array',
            'old_images' => 'array',
            'items' => 'array'
        ];
    }
    public function messages()
    {
        return [
            'colors.required' => 'حقل الالوان مطلوب',
            'colors.array'    => 'الالوان يجب ان تكون مصفوفة',
            'colors.*.integer' => 'كل لون يجب ان يكون رقما',
            'colors.*.in'     => 'قيمة اللون يجب ان تكون صحيحة',
        ];
    }
}
