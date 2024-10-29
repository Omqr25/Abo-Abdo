<?php

namespace App\Http\Resources;

use App\Enums\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "cost" => $this->cost,
            "type" => ExpenseType::from($this->type)->name(),
        ];
    }
}
