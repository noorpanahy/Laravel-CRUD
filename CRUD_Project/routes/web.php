<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function () {
    $posts = [];
    if (Auth::check()) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $posts = $user->usersCoolPosts()->latest()->get();
    }
    return view('welcome', ['posts' => $posts]);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/create-post', [PostController::class, 'createPost']);
