<?php

namespace App\Http\Requests\Item;

use App\Enums\ItemColor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'description' => 'required|string',
            'color' => ['required', new Enum(ItemColor::class)],
            'group_id' => 'required|exists:groups,id'
        ];
    }
}
