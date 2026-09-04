<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreMovieRequest;
use App\Http\Requests\Admin\UpdateMovieRequest;
use Illuminate\Support\Facades\Storage;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    public function index(Request $request)
    {
    $query = Movie::query();

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('year')) {
        $query->where('release_year', $request->year);
    }

    if ($request->filled('rating')) {
        $query->where('rating', '>=', $request->rating);
    }

    $movies = $query->latest()->paginate(10)->withQueryString();

    return view('admin.movies.index', compact('movies'));
    }
    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(StoreMovieRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('movies', 'public');
        }

        Movie::create($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie added successfully');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($movie->image) {
                Storage::disk('public')->delete($movie->image);
            }
            $validated['image'] = $request->file('image')->store('movies', 'public');
        }

        $movie->update($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie updated successfully');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie moved to trash');
    }
        public function trash()
    {
        $movies = Movie::onlyTrashed()->paginate(10);
        return view('admin.movies.trash', compact('movies'));
    }

    public function restore($id)
    {
        $movie = Movie::onlyTrashed()->findOrFail($id);
        $movie->restore();

        return redirect()->route('admin.movies.trash')->with('success', 'Movie restored successfully!');
    }

    public function forceDelete($id)
    {
        $movie = Movie::onlyTrashed()->findOrFail($id);

        if ($movie->image && Storage::disk('public')->exists($movie->image)) {
            Storage::disk('public')->delete($movie->image);
        }

        $movie->forceDelete();

        return redirect()->route('admin.movies.trash')->with('success', 'Movie permanently deleted!');
    }
    public function generateAiReview(int $id, GeminiService $geminiService): JsonResponse
    {
    $movie = Movie::findOrFail($id);

    $aiReview = Cache::remember("movie_ai_review_{$movie->id}", 86400, function () use ($movie, $geminiService) {
        return $geminiService->generateMovieReview($movie->title, $movie->description);
    });

    return response()->json([
        'status'    => true,
        'ai_review' => $aiReview ?? 'تعذر توليد التقييم في الوقت الحالي.',
    ]);
    }
}