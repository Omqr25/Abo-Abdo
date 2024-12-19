<?php

namespace Database\Factories;

use App\Enums\ExpenseType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "total" => $this->faker->numberBetween(0, 2000000),
            "type" => $this->faker->randomElement(ExpenseType::class),
        ];
    }
}
