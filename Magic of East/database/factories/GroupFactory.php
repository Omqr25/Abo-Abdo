<?php

namespace Database\Factories;

use App\Enums\ItemColor;
use App\Models\Classification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'description' => fake()->text(20),
            'color' => $this->faker->randomElement(ItemColor::class),
            'classification_id' => Classification::all()->random()->id,
            'workshop_id' => 1,
        ];
    }
}
