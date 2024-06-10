<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\MovieBroadcast;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::factory()->count(20)->create();

        $movies->each(function ($movie) {
            MovieBroadcast::factory()->count(3)->create([
                'movie_id' => $movie->id,
            ]);
        });
    }
}
