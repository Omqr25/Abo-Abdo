<?php

namespace Database\Factories;

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
            'group_id' => Item::all()->random()->id,
            'invoice_id' => Invoice::all()->random()->id,
            'net_price' => mt_rand(1,1000),
            'sell_price' => mt_rand(1,1000),
            'quantity' => fake()->numberBetween(1,200),
        ];
    }
}
