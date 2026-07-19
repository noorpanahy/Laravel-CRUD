<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>The Ledger — Messages</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ledger.css') }}">
</head>
<body>

    <div class="wrap">
        <div class="topbar">
            <p class="wordmark">The <span>Dark Coder</span></p>
            <div style="display:flex; align-items:center; gap:16px;">
                <a href="/" style="color: var(--muted); font-size: 13px; text-decoration: none;">Home</a>
                <span class="status-pill">signed in</span>
            </div>
        </div>

        <p class="section-label">Conversations</p>

        @forelse ($conversations as $user)
            <a href="/messages/{{ $user->id }}" class="entry" style="text-decoration:none; display:block;">
                <div class="entry-body">
                    <h3 class="entry-title">{{ $user->name }}</h3>
                </div>
            </a>
        @empty
            <div class="empty-state">No conversations yet. Start one below.</div>
        @endforelse

        <p class="section-label" style="margin-top: 32px;">Start a new conversation</p>

        @forelse ($allUsers as $user)
            <a href="/messages/{{ $user->id }}" class="entry" style="text-decoration:none; display:block;">
                <div class="entry-body">
                    <h3 class="entry-title">{{ $user->name }}</h3>
                    <p class="entry-meta">{{ $user->email }}</p>
                </div>
            </a>
        @empty
            <div class="empty-state">No other users registered yet.</div>
        @endforelse
    </div>

</body>
</html>
