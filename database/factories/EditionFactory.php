<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Edition>
 */
class EditionFactory extends Factory
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
            'publisher' => fake()->randomElement(['Panini Manga', 'Ivrea Argentina', 'ECC Comics', 'OVNI Press']),
            'language' => fake()->randomElement(['Inglés', 'Español', 'Japonés', 'Portugués', 'Italiano', 'Alemán']),
            'format' => fake()->randomElement(['Rustica/TPB (tapa blanda)', 'Grapa', 'Tapa dura', 'Bolsillo']),
            'description' => fake()->text($maxNbChars = 200),
            'isStandalone' => fake()->randomElement([0, 1]),
        ];
    }
}
