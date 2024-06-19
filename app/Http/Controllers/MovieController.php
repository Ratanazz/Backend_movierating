<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::all(); // Fetch all movies

        return response()->json($movies); // Return movies as JSON for Axios
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    $movie = Movie::with('comments.user', 'ratings')->findOrFail($id);
    $averageRating = $movie->averageRating();
    return response()->json([
        'movie' => $movie,
        'comments' => $movie->comments,
        'averageRating' => $averageRating,
        'youtubeVideoId' => $movie->youtube_video_id // Include YouTube video ID
    ]);
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'summary' => 'required|string',
            'genre' => 'required|string',
            'release_date' => 'nullable|date',
            'runtime_minutes' => 'nullable|string', // Ensure this matches the string type
            'rating' => 'required|numeric|between:0,10', // Correct range is 0 to 10
            'image_poster' => 'nullable|url', // Optional: must be a valid URL if provided
            'trailer' => 'nullable|url', // Optional: must be a valid URL if provided
        ]);
    
        $movie = Movie::create($validatedData);
    
        return response()->json($movie, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'summary' => 'required|string',
            'genre' => 'required|string',
            'release_date' => 'nullable|date',
            'runtime_minutes' => 'nullable|string', // Ensure this matches the string type
            'rating' => 'required|numeric|between:0,10', // Correct range is 0 to 10
            'image_poster' => 'nullable|url', // Optional: must be a valid URL if provided
            'trailer' => 'nullable|url', // Optional: must be a valid URL if provided
        ]);

        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }

        $movie->update($validatedData);

        return response()->json($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }

        $movie->delete();

        return response()->json(['message' => 'Movie deleted successfully']);
    }
}
