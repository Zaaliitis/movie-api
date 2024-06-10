<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\MovieBroadcast;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends Factory<MovieBroadcast>
 */
class MovieBroadcastFactory extends Factory
{
    protected $model = MovieBroadcast::class;

    public function definition(): array
    {
        return [
            'movie_id' => Movie::factory(),
            'channel_nr' => $this->faker->numberBetween(1, 100),
            'broadcasts_at' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
        ];
    }
}
