<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact — The Ledger</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ledger.css') }}">
</head>
<body>
    <div class="auth-wrap">
        <div class="auth-hero">
            <h1>Get in <span>touch</span></h1>
            <p>Send a message, we'll get back to you</p>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="auth-card">
            <form action="/contact" method="POST">
                @csrf
                <input class="field" name="name" placeholder="Your name" type="text" value="{{ old('name') }}">
                <input class="field" name="email" placeholder="Your email" type="text" value="{{ old('email') }}">
                <textarea class="field" name="message" placeholder="Your message">{{ old('message') }}</textarea>
                <button type="submit" class="btn-primary">Send message</button>
            </form>

            @error('name') <p class="form-error">{{ $message }}</p> @enderror
            @error('email') <p class="form-error">{{ $message }}</p> @enderror
            @error('message') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <p style="text-align:center; margin-top: 8px;">
            <a href="/" style="color: var(--muted); font-size: 13px; text-decoration: none;">← Back to The Ledger</a>
        </p>
    </div>
</body>
</html>
