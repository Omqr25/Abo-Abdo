<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceGroup>
 */
class InvoiceGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => Group::all()->random()->id,
            'invoice_id' => Invoice::all()->random()->id,
            'quantity' => fake()->numberBetween(1, 200),
        ];
    }
}
