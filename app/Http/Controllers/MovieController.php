<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieBroadcast;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->query('search');

        $movies = Movie::when($searchTerm, function ($query, $searchTerm) {
            return $query->where('title', 'like', "%{$searchTerm}%");
        })->paginate(10);

        return response()->json($movies);
    }

    public function show($id)
    {
        $movie = Movie::with(['broadcasts' => function ($query) {
            $query->orderBy('broadcasts_at');
        }])->findOrFail($id);

        return response()->json($movie);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100',
            'rating' => 'required|numeric',
            'age_restriction' => 'nullable|max:2',
            'description' => 'required|max:500',
            'premieres_at' => 'required|date',
        ]);

        $movie = Movie::create($validatedData);

        return response()->json($movie, 201);
    }

    public function addBroadcast(Request $request, $movieId)
    {
        $validatedData = $request->validate([
            'channel_nr' => 'required|integer',
            'broadcasts_at' => 'required|date',
        ]);

        $movie = Movie::findOrFail($movieId);

        $broadcast = new MovieBroadcast($validatedData);
        $movie->broadcasts()->save($broadcast);

        return response()->json($broadcast, 201);
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return response()->json(null, 204);
    }
}
