<?php


use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::POST('/register', [userController::class, 'register']);
Route::POST('/logout', [userController::class, 'logout']);