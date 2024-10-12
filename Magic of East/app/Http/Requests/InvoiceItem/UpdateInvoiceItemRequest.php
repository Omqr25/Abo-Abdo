<?php

namespace App\Http\Requests\InvoiceItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceItemRequest extends FormRequest
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
            'item_id' => 'exists:items,id',
            'invoice_id' => 'exists:invoices,id',
            'net_price' => 'numeric|gt:0',
            'sell_price' => 'numeric|gt:0',
            'quantity' => 'numeric|gt:0',
        ];
    }
}
