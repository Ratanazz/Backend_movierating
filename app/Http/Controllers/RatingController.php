<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'required|integer|min:1|max:10',
        ]);

        $rating = Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'movie_id' => $request->movie_id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        $movie = Movie::find($request->movie_id);
        $averageRating = $movie->averageRating();

        return response()->json([
            'rating' => $rating,
            'averageRating' => $averageRating,
        ], 201);
    }
}