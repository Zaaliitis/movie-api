<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\MovieBroadcast;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movie>
 */
class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'rating' => $this->faker->randomFloat(1, 1, 10),
            'age_restriction' => $this->faker->randomElement(['12', '14', '16', '18']),
            'description' => $this->faker->paragraph(3),
            'premieres_at' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
        ];
    }

    public function hasBroadcasts(int $count = 1): self
    {
        return $this->afterCreating(function (Movie $movie) use ($count) {
            MovieBroadcast::factory()->count($count)->create([
                'movie_id' => $movie->id,
            ]);
        });
    }
}
