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
            'description' => 'string|min:3',
            'color' => [new Enum(ItemColor::class)],
            'classification_id' => 'exists:classifications,id',
        ];
    }
}
