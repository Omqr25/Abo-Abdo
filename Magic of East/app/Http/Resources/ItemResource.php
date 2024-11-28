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
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'sizes' => [
                'height' => $this->height,
                'width' => $this->width,
                'depth' => $this->depth,
            ],
        ];
        return $data;
    }
}
