<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $incomingField = $request->validate([
            'body' => ['required', 'min:1', 'max:1000'],
        ]);

        $incomingField['body'] = strip_tags($incomingField['body']);
        $incomingField['user_id'] = Auth::id();
        $incomingField['post_id'] = $postId;

        Comment::create($incomingField);

        return back();
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();

        return back();
    }
}