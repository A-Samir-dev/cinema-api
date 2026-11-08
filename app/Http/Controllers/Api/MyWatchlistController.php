<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMyWatchlistRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class MyWatchlistController extends Controller
{
    private function key(Request $request): string
    {
        return 'user-' . $request->user()->id;
    }

    public function index(Request $request)
    {
        $ids = Watchlist::where('device_id', $this->key($request))->pluck('movie_id');
        $movies = Movie::whereIn('id', $ids)->get();

        return response()->json([
            'status' => true,
            'message' => 'Watchlist fetched successfully',
            'data' => MovieResource::collection($movies),
        ]);
    }

    public function store(StoreMyWatchlistRequest $request)
    {
        Watchlist::firstOrCreate([
            'device_id' => $this->key($request),
            'movie_id' => $request->validated()['movie_id'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Added to watchlist',
            'data' => null,
        ], 201);
    }

    public function destroy(Request $request, $movieId)
    {
        Watchlist::where('device_id', $this->key($request))
            ->where('movie_id', $movieId)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Removed from watchlist',
            'data' => null,
        ]);
    }
}