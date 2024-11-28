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
        $colors = ItemColor::cases();
        $selectedColors = $this->faker->randomElements(array_map(fn($color) => $color->value, $colors), random_int(1, count($colors)));
        return [
            'name' => fake()->name,
            'net_price' => mt_rand(1,1000),
            'description' => fake()->text(20),
            'colors' => json_encode($selectedColors),
            'classification_id' => Classification::all()->random()->id,
            'workshop_id' => 1,
        ];
    }
}