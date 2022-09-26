<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Volume>
 */
class VolumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->name(),
            'ISBN' => fake()->isbn13(),
            'argument' => fake()->text($maxNbChars = 250),
            'coverImage' => fake()->imageUrl($width = 1400, $height = 2000),
            'edition_id' => fake()->numberBetween(2, 9),
        ];
    }
}
