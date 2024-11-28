<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'groups' => 'required|array',
            'groups.*.id' => 'required|exists:groups,id',
            'groups.*.quantity' => 'required|numeric|gt:0',
            'notes' => 'string|min:3',
            //'with_delivery' => 'required|boolean',
            'total_sell_price' => 'required|numeric|gt:0',
        ];
    }
}
