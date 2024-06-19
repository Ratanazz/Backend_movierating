<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'movie_id' => $request->movie_id,
            'content' => $request->content,
        ]);

        return response()->json($comment->load('user'), 201);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted']);
    }

    public function getCommentsWithRatings($movieId)
{
    $comments = Comment::with(['user', 'rating'])->where('movie_id', $movieId)->get();

    return response()->json($comments);
}
}