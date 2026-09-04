<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreWatchlistRequest;
use App\Http\Requests\Api\DeleteWatchlistRequest;
use App\Http\Resources\WatchlistResource;
use App\Models\Watchlist;
use Illuminate\Http\JsonResponse;

class WatchlistController extends Controller
{
    public function index(string $deviceId): JsonResponse
    {
        $watchlist = Watchlist::with('movie')
            ->where('device_id', $deviceId)
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Watchlist retrieved successfully.',
            'data'    => WatchlistResource::collection($watchlist),
        ], 200);
    }

    public function store(StoreWatchlistRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $exists = Watchlist::where($validated)->exists();

        if ($exists) {
            return response()->json([
                'status'  => false,
                'message' => 'Movie is already in your watchlist.',
            ], 409);
        }

        $watchlist = Watchlist::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Movie added to watchlist successfully.',
            'data'    => new WatchlistResource($watchlist->load('movie')),
        ], 201);
    }

    public function destroy(DeleteWatchlistRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $deleted = Watchlist::where($validated)->delete();

        if (!$deleted) {
            return response()->json([
                'status'  => false,
                'message' => 'Movie not found in your watchlist.',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Movie removed from watchlist successfully.',
        ], 200);
    }
}