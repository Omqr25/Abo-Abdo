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
        if ($request->route()->getName() === 'classifications.getgroups') {
            return [
                'name' => $this->name,
                'photos' => $this->media->map(function ($mediaItem) {
                    return [
                        'path' => config('app.url') . '/' . $mediaItem->path
                    ];
                })
            ];
        }
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'colors' => json_decode($this->colors, true),
            'items' => ItemResource::collection($this->items),
            'photos' =>  $this->media->map(function ($mediaItem) {
                return [
                    'id' => $mediaItem->id,
                    'path' => config('app.url') . $mediaItem->path,
                ];
            }),
        ];
        if ($request->route()->getName() === 'invoices.index' || $request->route()->getName() === 'invoices.show') {
            $data['pivot'] = ($this->pivot)->only('net_price', 'sell_price', 'quantity');
        }

        return $data;
    }
}
