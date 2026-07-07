<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
        $incomingField = $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'body'  => ['required', 'min:5', 'max:10000'],
        ]);

        $incomingField['title'] = strip_tags($incomingField['title']);
        $incomingField['body'] = strip_tags($incomingField['body']);
        $incomingField['user_id'] = Auth::id();

        Post::create($incomingField);

        return redirect('/');
    }
}
