<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Ledger</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ledger.css') }}">
</head>
<body>

@auth
    <div class="wrap">
        <div class="topbar">
            <p class="wordmark">The <span>Dark Coder</span></p>
            <div style="display:flex; align-items:center; gap:16px;">
                <a href="/messages" style="color: var(--muted); font-size: 13px; text-decoration: none;">Messages</a>
                <a href="/contact" style="color: var(--muted); font-size: 13px; text-decoration: none;">Contact</a>
                <span class="status-pill">signed in</span>
                <form method="POST" action="/logout" style="margin:0;">
                    @csrf
                    <button class="logout-btn">Log out</button>
                </form>
            </div>
        </div>

        <div class="composer">
            <h2>New entry</h2>
            <form action="/create-post" method="POST" enctype="multipart/form-data">
                @csrf
                <input class="field" name="title" placeholder="Title" type="text">
                <textarea class="field" name="body" placeholder="What's on your mind?"></textarea>
                <input class="field file-field" type="file" name="image" accept="image/*">
                <button type="submit" class="btn-primary">Save entry</button>
            </form>
        </div>

        <p class="section-label">All entries</p>

        @forelse ($posts as $index => $post)
            <div class="entry">
                <div class="entry-number">№ {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</div>
                <div class="entry-body">
                    <h3 class="entry-title">{{ $post->title }}</h3>
                    <p class="entry-meta">by {{ $post->user->name }} · {{ $post->created_at->format('M j, Y') }}</p>
                    <p class="entry-text">{{ $post->body }}</p>
                    @if ($post->image)
                        <img class="entry-image" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                    @endif
                    <div class="entry-actions">
                        <div class="comments">
                            @foreach ($post->comments as $comment)
                                <div class="comment">
                                    <p class="comment-text"><strong>{{ $comment->user->name }}:</strong> {{ $comment->body }}</p>
                                    @if ($comment->user_id === auth()->id())
                                        <form class="delete-form" action="/comment/{{ $comment->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="delete-btn">Remove</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach

                            <form action="/post/{{ $post->id }}/comment" method="POST" class="comment-form">
                                @csrf
                                <input class="field" name="body" placeholder="Write a comment..." type="text">
                                <button type="submit" class="btn-secondary">Reply</button>
                            </form>
                        </div>
                        <a href="/edit-post/{{ $post->id }}">Edit</a>
                        <form class="delete-form" action="/delete-post/{{ $post->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="delete-btn">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">No entries yet. Write your first one above.</div>
        @endforelse
    </div>
@else
    <div class="auth-wrap">
        <div class="auth-hero">
            <h1>The <span>Ledger</span></h1>
            <p>A quiet place to keep your notes</p>
        </div>

        <div class="auth-card">
            <h2>Create account</h2>
            <form action="/register" method="POST">
                @csrf
                <input class="field" placeholder="Name" name="name" type="text">
                <input class="field" placeholder="Email" name="email" type="text">
                <input class="field" type="password" placeholder="Password" name="password">
                <button class="btn-primary">Register</button>
            </form>
        </div>

        <div class="auth-card">
            <h2>Sign in</h2>
            <form action="/login" method="POST">
                @csrf
                <input class="field" placeholder="Name" name="loginname" type="text">
                <input class="field" type="password" placeholder="Password" name="loginpassword">
                <button class="btn-primary">Log in</button>
            </form>
        </div>
    </div>
@endauth

</body>
</html>
