<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::all()->random()->id,
            'notes' => fake()->text,
            'with_delivery' => fake()->boolean(),
            'total_net_price' => fake()->randomNumber(), // mt_rand(1, 9999999)
            'total_sell_price' => mt_rand(1, 9999999), // mt_rand(1, 9999999)
        ];
    }
}
