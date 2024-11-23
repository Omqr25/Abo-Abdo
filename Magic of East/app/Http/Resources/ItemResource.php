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
            'size' => [
                'height' => $this->height,
                'width' => $this->width,
                'depth' => $this->depth,
            ],
        ];


        if($request->route()->getName() !== 'groups.store'){
            $data['group'] = [
                'id' => $this->group_id,
                'name' => $this->group->name ?? null,
            ];
            $data['classification'] = [
                'id' => $this->group->classification->id ?? null,
                'name' => $this->group->classification->name ?? null,
            ];
        }

        return $data; 
    }
}
