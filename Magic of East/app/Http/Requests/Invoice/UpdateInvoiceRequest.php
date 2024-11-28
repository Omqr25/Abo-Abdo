<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            'customer_id' => 'exists:customers,id',
            'groups' => 'array',
            'groups.*.id' => 'exists:groups,id',
            'groups.*.quantity' => 'numeric|gt:0',
            'notes' => 'string|min:3',
            //'with_delivery' => 'boolean',
            'total_sell_price' => 'numeric|gt:0',
        ];
    }
}
