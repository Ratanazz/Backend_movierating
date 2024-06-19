<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\YouTubeCommentsController;

Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'getUser']);
Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index']);
    Route::post('/', [MovieController::class, 'store'])->middleware('auth:sanctum');

    Route::get('/search', [MovieController::class, 'search']); // will use later
    Route::get('/genre/{genre}', [MovieController::class, 'byGenre']); // will use later
    Route::get('/latest', [MovieController::class, 'latest']); // will use later
    Route::get('/top-rated', [MovieController::class, 'topRated']); // will use later

    Route::prefix('{movie}')->where(['movie' => '[0-9]+'])->group(function () {
        Route::get('/', [MovieController::class, 'show']);
        Route::put('/', [MovieController::class, 'update'])->middleware('auth:sanctum');
        Route::delete('/', [MovieController::class, 'destroy'])->middleware('auth:sanctum');
        Route::get('/comments', [CommentController::class, 'getCommentsWithRatings']); // get rating and comment both
        // Route::get('/comments', [MovieController::class, 'getComments']); //get only comment
        Route::get('/ratings', [MovieController::class, 'getRatings']); //get only rating
    });
});
Route::get('/movies', [MovieController::class, 'index']);
Route::post('/movies', [MovieController::class, 'store']);
Route::get('/movies/{movie}', [MovieController::class, 'show'])->where('movie', '[0-9]+');
Route::put('/movies/{movie}', [MovieController::class, 'update'])->where('movie', '[0-9]+');
Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->where('movie', '[0-9]+');

Route::get('/youtube-comments/{videoId}', [YouTubeCommentsController::class, 'getComments']);
// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profile', [ApiController::class, 'profile']);

    // Comment Routes
    Route::prefix('comments')->group(function () {
        Route::post('/', [CommentController::class, 'store']);
        Route::put('/{comment}', [CommentController::class, 'update']);
        Route::delete('/{comment}', [CommentController::class, 'destroy']);
    });

    // Rating Routes
    Route::prefix('ratings')->group(function () {
        Route::post('/', [RatingController::class, 'store']);
        Route::get('/user/{movie}', [RatingController::class, 'getUserRating']); // will use later
    });

    // User's Movies, Comments, and Ratings
    Route::get('/user/movies', [MovieController::class, 'userMovies']); // will use later
    Route::get('/user/comments', [CommentController::class, 'userComments']); // will use later
    Route::get('/user/ratings', [RatingController::class, 'userRatings']); // will use later
});
