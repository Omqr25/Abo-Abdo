<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "firstname"=> $this->firstname,
            "lastname"=> $this->lastname,
            "phonenumber"=> $this->phonenumber,
            "address" => $this->address,
            "position" => $this->position,
            "salary" => $this->salary,
        ];
    }
}