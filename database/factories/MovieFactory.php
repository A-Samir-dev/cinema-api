<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    return [
        'title' => fake()->sentence(3),
        'description' => fake()->paragraph(),
        'release_year' => fake()->numberBetween(1990, 2026),
        'rating' => fake()->randomFloat(1, 1, 10),
        'image' => 'https://via.placeholder.com/300x450.png?text=Movie+Poster',
    ];
    }
}
