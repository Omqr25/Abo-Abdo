<?php

namespace App\Http\Resources;

use App\Enums\ItemColor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'name' => $this->name,
            'description'  => $this->description,
            'color' => ($this->color instanceof ItemColor) ? $this->color->name : null,
            'group' => [
                'id' => $this->group_id,
                'name' => $this->group->name ?? null,
            ],
            'classification' => [
                'id' => $this->group->classification->id,
                'name' => $this->group->classification->name ?? null,
            ]
        ];
    }
}
