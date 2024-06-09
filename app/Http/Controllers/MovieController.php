<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieBroadcast;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $searchTerm = $request->query('search');

            $movies = Movie::when($searchTerm, function ($query, $searchTerm) {
                return $query->where('title', 'like', "%{$searchTerm}%");
            })->paginate(10);

            return response()->json($movies);
        } catch (Exception $e) {
            Log::error('Error fetching movies: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching the movies'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $movie = Movie::with(['broadcasts' => function ($query) {
                $query->orderBy('broadcasts_at');
            }])->findOrFail($id);

            return response()->json($movie);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Movie not found'], 404);
        } catch (Exception $e) {
            Log::error('Error fetching movie: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching the movie'], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|max:100',
                'rating' => 'required|numeric',
                'age_restriction' => 'nullable|max:2',
                'description' => 'required|max:500',
                'premieres_at' => 'required|date',
            ]);

            $movie = Movie::create($validatedData);

            return response()->json($movie, 201);
        } catch (Exception $e) {
            Log::error('Error storing movie: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while storing the movie'], 500);
        }
    }

    public function addBroadcast(Request $request, $movieId): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'channel_nr' => 'required|integer',
                'broadcasts_at' => 'required|date',
            ]);

            $movie = Movie::findOrFail($movieId);

            $broadcast = new MovieBroadcast($validatedData);
            $movie->broadcasts()->save($broadcast);

            return response()->json($broadcast, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Movie not found'], 404);
        } catch (Exception $e) {
            Log::error('Error adding broadcast: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while adding the broadcast'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $movie = Movie::findOrFail($id);
            $movie->delete();

            return response()->json(['message' => 'Movie deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Movie not found'], 404);
        } catch (Exception $e) {
            Log::error('Error deleting movie: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the movie'], 500);
        }
    }
}
