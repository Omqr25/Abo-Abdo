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
        if ($request->route()->getName() === 'invoices.index') {
            return [
                'id' => $this->id,
                'customer' => ($this->customer->firstname . ' ' . $this->customer->lastname) ?? null,
                'date' => $this->created_at->format('Y/m/d')
            ];
        }
        $data = [
            'id' => $this->id,
            'customer' => ($this->customer->firstname . ' ' . $this->customer->lastname) ?? null,
            'notes' => $this->notes,
            //'with_delivery' => $this->with_delivery,
            'total_net_price' => $this->total_net_price,
            'total_sell_price' => $this->total_sell_price,
            'date' => $this->created_at->format('Y/m/d')
        ];

        if ($request->route()->getName() === 'invoices.show') {
            $data['groups'] = GroupResource::collection($this->groups->map(function ($group) {
                return new GroupResource($group, $this->id);
            }));
        }

        return $data;
    }
}
