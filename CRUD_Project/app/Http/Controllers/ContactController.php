<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $incomingField = $request->validate([
            'name'    => ['required', 'min:2', 'max:100'],
            'email'   => ['required', 'email'],
            'message' => ['required', 'min:5', 'max:2000'],
        ]);

        $incomingField['message'] = strip_tags($incomingField['message']);

        ContactMessage::create($incomingField);

        return redirect('/contact')->with('success', 'Your message has been sent.');
    }
}