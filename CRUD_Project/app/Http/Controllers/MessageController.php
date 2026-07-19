<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function inbox()
    {
        $userId = Auth::id();

        $conversations = User::whereHas('sentMessages', fn($q) => $q->where('receiver_id', $userId))
            ->orWhereHas('receivedMessages', fn($q) => $q->where('sender_id', $userId))
            ->where('id', '!=', $userId)
            ->get();

        // everyone else, so the user can start a new conversation
        $allUsers = User::where('id', '!=', $userId)->get();

        return view('messages.inbox', compact('conversations', 'allUsers'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'body' => $request->body,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function show(User $user)
    {
        return view('messages.show', compact('user'));
    }
}