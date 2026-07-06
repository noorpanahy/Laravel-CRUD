<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function Register(Request $request)
    {
        $userInput = $request->validate([
            'name' => ['required', 'min:3', 'max:64', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:32']
        ]);

        $userInput['password'] = bcrypt($userInput['password']);
        $user = User::create($userInput);
        Auth::login($user);
        return redirect('/');
    }
}