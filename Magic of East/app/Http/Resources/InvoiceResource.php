<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'customer' => [
                'id' => $this->customer_id,
                'name' => ($this->customer->firstname . ' ' . $this->customer->lastname) ?? null,
            ],
            'notes' => $this->notes,
            'with_delivery' => $this->with_delivery,
            'total_net_price' => $this->total_net_price,
            'total_sell_price' => $this->total_sell_price,
        ];

        if ($request->route()->getName() === 'invoices.index' || $request->route()->getName() === 'invoices.show') {
            $data['groups'] = GroupResource::collection($this->groups);
        }

        return $data;
    }
}
