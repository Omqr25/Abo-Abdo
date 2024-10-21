<?php

namespace Database\Factories;

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
        $sizes = ['small', 'medium', 'big'];
        return [
            'name' => fake()->name,
            'sizes' => $sizes[array_rand($sizes)],
            'group_id' => Group::all()->random()->id,
        ];
    }
}
