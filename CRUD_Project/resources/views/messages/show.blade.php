<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat with {{ $user->name }} — The Ledger</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ledger.css') }}">
</head>
<body>

<div class="wrap">
    <div class="topbar">
        <p class="wordmark">The <span>Dark Coder</span></p>
        <div style="display:flex; align-items:center; gap:16px;">
            <a href="/messages" style="color: var(--muted); font-size: 13px; text-decoration: none;">← Inbox</a>
            <span class="status-pill">chatting with {{ $user->name }}</span>
        </div>
    </div>

    <p class="section-label">Chat with {{ $user->name }}</p>

    <div id="chat-box" style="max-height: 400px; overflow-y: auto; margin-bottom: 16px; display:flex; flex-direction:column; gap:8px;"></div>

    <form id="chat-form" class="composer" style="display:flex; gap:8px;">
        <input class="field" id="chat-input" placeholder="Type a message..." autocomplete="off" style="flex:1;">
        <button type="submit" class="btn-primary">Send</button>
    </form>
</div>

@vite('resources/js/app.js')
<script>
    const currentUserId = {{ auth()->id() }};
    const otherUserId = {{ $user->id }};
    const otherUserName = @json($user->name);
    const chatBox = document.getElementById('chat-box');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');

    function appendMessage(msg) {
        const div = document.createElement('div');
        div.className = 'comment';
        const who = msg.sender_id === currentUserId ? 'You' : otherUserName;
        div.innerHTML = `<p class="comment-text"><strong>${who}:</strong> ${msg.body}</p>`;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // load existing history
    fetch(`/messages-data/${otherUserId}`)
        .then(res => res.json())
        .then(messages => messages.forEach(appendMessage));

    // listen for new messages in real time
    const ids = [currentUserId, otherUserId].sort((a, b) => a - b);
    window.Echo.private(`chat.${ids[0]}.${ids[1]}`)
        .listen('.message.sent', (e) => appendMessage(e));

    // send new message
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const body = input.value.trim();
        if (!body) return;

        const res = await fetch(`/messages/${otherUserId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ body }),
        });
        const message = await res.json();
        appendMessage(message);
        input.value = '';
    });
</script>

</body>
</html>
