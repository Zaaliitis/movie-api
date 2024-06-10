<?php

namespace Tests\Unit;

use App\Models\Movie;
use App\Models\MovieBroadcast;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieBroadcastTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_broadcast_belongs_to_a_movie(): void
    {
        $movie = Movie::factory()->create();
        $broadcast = MovieBroadcast::factory()->create(['movie_id' => $movie->id]);

        $this->assertInstanceOf(Movie::class, $broadcast->movie);
        $this->assertEquals($movie->id, $broadcast->movie->id);
    }
}
