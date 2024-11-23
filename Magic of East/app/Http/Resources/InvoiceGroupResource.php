<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group' => new GroupResource($this->group),
            'invoice' => new InvoiceResource($this->invoice),
            'net_price' => $this->net_price,
            'sell_price' => $this->sell_price,
            'quantity' => $this->quantity,
        ];
    }
}
