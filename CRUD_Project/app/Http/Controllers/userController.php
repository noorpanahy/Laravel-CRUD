<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{

    public function login(Request $request)
    {
        $userInput = $request->validate([
            'loginname' => ['required'],
            'loginpassword' => ['required']
        ]);

        if (Auth::attempt([
            'name' => $userInput['loginname'],
            'password' => $userInput['loginpassword']
        ])) {
            $request->session()->regenerate();
        };

        return redirect('/');
    }

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
