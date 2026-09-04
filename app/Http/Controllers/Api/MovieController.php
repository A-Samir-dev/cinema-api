<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $movies = $query->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Movies fetched successfully',
            'data' => MovieResource::collection($movies)
        ], 200);
    }

    public function show($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'status' => false,
                'message' => 'Movie not found'
            ], 404);
        }

        $similarMovies = Movie::where('id', '!=', $movie->id)
            ->where(function($q) use ($movie) {
                $q->where('release_year', $movie->release_year)
                  ->orWhereBetween('rating', [$movie->rating - 1, $movie->rating + 1]);
            })
            ->take(4)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Movie details fetched successfully',
            'data' => [
                'movie' => new MovieResource($movie),
                'similar_movies' => MovieResource::collection($similarMovies)
            ]
        ], 200);
    }
}