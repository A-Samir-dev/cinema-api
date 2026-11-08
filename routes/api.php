<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\WatchlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MyWatchlistController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Movies
Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);

// Watchlist
Route::prefix('watchlist')->group(function () {
    Route::get('/{deviceId}', [WatchlistController::class, 'index']);
    Route::post('/', [WatchlistController::class, 'store']);
    Route::delete('/', [WatchlistController::class, 'destroy']);
});

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
// My Watchlist (logged-in users)
Route::middleware('auth:sanctum')->prefix('my-watchlist')->group(function () {
    Route::get('/', [MyWatchlistController::class, 'index']);
    Route::post('/', [MyWatchlistController::class, 'store']);
    Route::delete('/{movieId}', [MyWatchlistController::class, 'destroy']);
});