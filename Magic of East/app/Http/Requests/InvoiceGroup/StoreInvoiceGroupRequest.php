<?php

namespace App\Http\Requests\InvoiceGroup;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceGroupRequest extends FormRequest
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
            'group_id' => 'required|exists:groups,id',
            'invoice_id' => 'required|exists:invoices,id',
            'net_price' => 'required|numeric|gt:0',
            'sell_price' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0',
        ];
    }
}
