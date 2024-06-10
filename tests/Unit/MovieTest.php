<?php

namespace Tests\Unit;

use App\Models\Movie;
use App\Models\MovieBroadcast;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_movie_has_many_broadcasts(): void
    {
        $movie = Movie::factory()->create();
        $broadcast1 = MovieBroadcast::factory()->create(['movie_id' => $movie->id]);
        $broadcast2 = MovieBroadcast::factory()->create(['movie_id' => $movie->id]);

        $this->assertTrue($movie->broadcasts->contains($broadcast1));
        $this->assertTrue($movie->broadcasts->contains($broadcast2));
        $this->assertEquals(2, $movie->broadcasts->count());
    }
}
