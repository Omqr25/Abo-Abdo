<?php

namespace App\Http\Resources;

use App\Enums\ItemColor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'color' => ($this->color instanceof ItemColor) ? $this->color->name : null,
            'classification' => [
                'id' => $this->classification_id,
                'name' => $this->classification->name ?? null,
            ],
        ];
        if($request->route()->getName() === 'invoices.show'){
            $data['pivot'] = ($this->pivot)->only('net_price','sell_price','quantity');
        }

        return $data;
    }
}
