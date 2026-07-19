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
            'image' => ['nullable', 'image', 'max:2048'], // 2MB limit, must be an actual image
        ]);

        $incomingField['title'] = strip_tags($incomingField['title']);
        $incomingField['body'] = strip_tags($incomingField['body']);
        $incomingField['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $incomingField['image'] = $request->file('image')->store('post-images', 'public');
        }

        Post::create($incomingField);

        return redirect('/');
    }

    public function editController(Post $post)
    {
        if (Auth::user()->id !== $post['user_id']) {
            return redirect('/');
        }

        return view('edit-post', ['post' => $post]);
    }

    public function updatedData(Post $post, Request $request)
    {
        if (Auth::user()->id !== $post['user_id']) {
            return redirect('/');
        }

        $incomingField = $request->validate([
            'title' => 'required',
            'body'  => 'required'
        ]);

        $incomingField['title'] = strip_tags($incomingField['title']);
        $incomingField['body'] = strip_tags($incomingField['body']);

        $post->update($incomingField);
        return redirect('/');
    }

    public function deletePost(Post $post)
    {
        if (Auth::user()->id === $post['user_id']) {
            $post->delete();
        }
        return redirect('/');
    }
}