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


    public function __construct($resource)
    {
        parent::__construct($resource);
    }
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "total" => $this->total,
            "type" => ExpenseType::from($this->type)->value,
            "date" => $this->created_at->format('Y/m')
        ];
    }
}
