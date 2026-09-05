<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,('update')])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
    Route::post('/chatbot/send', [ChatbotController::class, 'chat'])->name('chatbot.send');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::post('movies/{id}/ai-review', [MovieController::class, 'generateAiReview'])->name('movies.aiReview');

    Route::get('movies/trash', [MovieController::class, 'trash'])->name('movies.trash');
    Route::patch('movies/{id}/restore', [MovieController::class, 'restore'])->name('movies.restore');
    Route::delete('movies/{id}/force-delete', [MovieController::class, 'forceDelete'])->name('movies.forceDelete');

    Route::resource('movies', MovieController::class);
});

require __DIR__.'/auth.php';