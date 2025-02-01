<?php

namespace App\Http\Resources;

use App\Enums\ItemColor;
use App\Models\InvoiceGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class GroupResource extends JsonResource
{
    protected $invoiceId;
    public function __construct($resource, $invoiceId = null)
    {
        parent::__construct($resource);
        $this->invoiceId = $invoiceId;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->route()->getName() === 'classifications.getgroups' || $request->route()->getName() === 'groups.index') {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'photos' => $this->media->map(function ($mediaItem) {
                    return config('app.url') . '/' . $mediaItem->path;
                })
            ];
        }
        if ($request->route()->getName() === 'invoices.index' || $request->route()->getName() === 'invoices.show') {
            $quantity = InvoiceGroup::where('group_id', $this->id)->where('invoice_id', $this->invoiceId)->select(DB::raw('quantity'))->first();
            return [
                'name' => $this->name,
                'quantity' => $quantity->quantity,
                'workshop' => $this->workshop->name,
            ];
        }
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'net_price' => $this->net_price,
            'description' => $this->description,
            'classification_id' => $this->classification_id,
            'colors' => json_decode($this->colors, true),
            'items' => ItemResource::collection($this->items),
            'state' => $this->state,
            'photos' =>  $this->media->map(function ($mediaItem) {
                return [
                    'id' => $mediaItem->id,
                    'path' => config('app.url') . '/' . $mediaItem->path,
                ];
            }),
        ];
        return $data;
    }
}
