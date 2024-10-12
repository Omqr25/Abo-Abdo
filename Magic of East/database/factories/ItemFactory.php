<?php

namespace Database\Factories;

use App\Enums\ItemColor;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
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
            'color' => $this->faker->randomElement(ItemColor::class),
            'description' => fake()->text,
            'group_id' => Group::all()->random()->id,
        ];
    }
}
