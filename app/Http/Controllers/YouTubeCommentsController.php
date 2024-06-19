<?php

namespace App\Http\Controllers;
use App\Models\Movie;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class YouTubeCommentsController extends Controller
{
    public function getComments($videoId) {
        $apiKey = 'AIzaSyBNcNUh-0t4QBFPm898Aja9Ra_75h9GI0s';
        $client = new Client([
            'verify' => false // This disables SSL verification
        ]);
        $response = $client->get("https://www.googleapis.com/youtube/v3/commentThreads", [
            'query' => [
                'part' => 'snippet',
                'videoId' => $videoId,
                'key' => $apiKey,
                'maxResults' => 100, // can adjust
            ]
        ]);
    
        return $response->getBody()->getContents();
        }
        public function show(Movie $movie) {
            $movie->load('comments.user', 'ratings');
            $averageRating = $movie->averageRating();
            $youtubeVideoId = $movie->getYoutubeVideoId();
            return response()->json([
                'movie' => $movie,
                'comments' => $movie->comments,
                'averageRating' => $averageRating,
                'youtubeVideoId' => $youtubeVideoId
            ]);
        }
}
