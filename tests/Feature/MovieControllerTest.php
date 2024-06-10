<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\MovieBroadcast;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @return array<string, string>
     */
    private function getHeaders(): array
    {
        $username = env('API_USERNAME');
        $password = env('API_PASSWORD');
        $credentials = base64_encode("{$username}:{$password}");

        return [
            'Authorization' => "Basic {$credentials}",
        ];
    }

    /** @test */
    public function it_can_list_movies(): void
    {
        $movies = Movie::factory()->count(3)->create();

        $response = $this->getJson('/api/movies', $this->getHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_show_a_movie_with_broadcasts(): void
    {
        $movie = Movie::factory()->create();
        $broadcasts = MovieBroadcast::factory()->count(3)->create(['movie_id' => $movie->id]);

        $response = $this->getJson("/api/movies/{$movie->id}", $this->getHeaders());

        $response->assertStatus(200)
            ->assertJsonPath('id', $movie->id)
            ->assertJsonCount(3, 'broadcasts');
    }

    /** @test */
    public function it_can_create_a_movie(): void
    {
        $movieData = Movie::factory()->make([
            'premieres_at' => now()->format('Y-m-d H:i:s'),
        ])->toArray();

        $response = $this->postJson('/api/movies', $movieData, $this->getHeaders());

        $response->assertStatus(201)
            ->assertJsonPath('title', $movieData['title']);
    }

    /** @test */
    public function it_can_add_a_broadcast_to_a_movie(): void
    {
        $movie = Movie::factory()->create();
        $broadcastData = MovieBroadcast::factory()->make([
            'movie_id' => $movie->id,
            'broadcasts_at' => now()->format('Y-m-d H:i:s'),
        ])->toArray();

        $response = $this->postJson("/api/movies/{$movie->id}/broadcasts", $broadcastData, $this->getHeaders());

        $response->assertStatus(201)
            ->assertJsonPath('movie_id', $movie->id);
    }

    /** @test */
    public function it_can_delete_a_movie(): void
    {
        $movie = Movie::factory()->create();

        $response = $this->deleteJson("/api/movies/{$movie->id}", [], $this->getHeaders());

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Movie deleted successfully');
    }
    /** @test */
    public function it_returns_validation_errors_when_creating_a_movie_with_missing_fields(): void
    {
        $response = $this->postJson('/api/movies', [], $this->getHeaders());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'rating', 'description', 'premieres_at']);
    }

    /** @test */
    public function it_returns_404_when_showing_a_non_existent_movie(): void
    {
        $response = $this->getJson('/api/movies/999', $this->getHeaders());

        $response->assertStatus(404)
            ->assertJsonPath('error', 'Movie not found');
    }

    /** @test */
    public function it_returns_paginated_results(): void
    {
        Movie::factory()->count(15)->create();

        $response = $this->getJson('/api/movies?page=2', $this->getHeaders());
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonPath('current_page', 2);
    }

    /** @test */
    public function it_can_search_movies_by_title(): void
    {
        Movie::factory()->create(['title' => 'Spider-Man']);
        Movie::factory()->create(['title' => 'Batman']);

        $response = $this->getJson('/api/movies?search=spider', $this->getHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Spider-Man');
    }
}
