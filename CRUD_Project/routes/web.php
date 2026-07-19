<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
// routes/channels.php
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
// routes/web.php or api.php
use App\Http\Controllers\MessageController;


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

Route::get('/edit-post/{post}', [PostController::class, 'editController']);
Route::put('/edit-post/{post}', [PostController::class, 'updatedData']);
Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);



Route::post('/post/{postId}/comment', [CommentController::class, 'store']);
Route::delete('/comment/{comment}', [CommentController::class, 'destroy']);


Route::get('/contact', [ContactController::class, 'create']);
Route::post('/contact', [ContactController::class, 'store']);



Broadcast::channel('chat.{userA}.{userB}', function (User $user, int $userA, int $userB) {
    return in_array($user->id, [$userA, $userB]);
});






// routes/web.php
Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'inbox']);
    Route::get('/messages/{user}', [MessageController::class, 'show']);
    Route::get('/messages-data/{user}', [MessageController::class, 'index']); // JSON history
    Route::post('/messages/{user}', [MessageController::class, 'store']);
});