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
    protected $type;

    public function __construct($resource, $type)
    {
        parent::__construct($resource);
        $this->type = $type;
    }
    public function toArray(Request $request): array
    {
        if ($this->type == 4) {
            return [
                'id' => $this->id,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'salary' => $this->salary,
                'rewards' => $this->rewards,
                ''
            ];
        }
        return [
            "id" => $this->id,
            "name" => $this->name,
            "cost" => $this->cost,
            "type" => ExpenseType::from($this->type)->name(),
        ];
    }
}
