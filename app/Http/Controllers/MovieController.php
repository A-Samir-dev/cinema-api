<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Services\GeminiService;

class MovieController extends Controller
{
    public function generateAiReview($id, GeminiService $gemini)
    {
        $movie = Movie::findOrFail($id);

        $title = $movie->title ?? 'Test Movie';
        $description = $movie->description ?? 'Test Description';

        $review = $gemini->generateMovieReview($title, $description);

        return response()->json([
            'status' => true,
            'ai_review' => $review
        ]);
    }
}