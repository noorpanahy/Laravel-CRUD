<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    @auth
<p>your logged in!</p>
<form method="POST" action="/logout">
    @csrf
    <button>Logout</button>
</form>

    <div style="border: 3px solid black; margin:5x;padding:5px">
        <h2>Create Post</h2>
        <form action="/create-post" method="POST">
            @csrf
            <input name="title" placeholder="Title Name" type="text">
            <textarea name="body" placeholder="Body OF Post"></textarea>
            <button type="submit">Save Post</button>
        </form>
    </div>

    <div style="border: 3px solid black;padding:10px">
        <h2>All Posts</h2>
        @foreach ($posts as $post)
    <div style="background-color:gray;padding:10px;margin:10px">
        <h3>{{ $post->title }}</h3>
        <p>{{ $post->body }}</p>
    </div>
@endforeach
    </div>

    @else
    <div style="border: 3px solid black; margin:5px; padding:5px ">
        <h2>Register</h2>
        <form action="/register" method="POST">
            @csrf
            <input placeholder="name" name="name" type="text">
            <input placeholder="email" name="email" type="text">
            <input type="password" placeholder="password" name="password">
            <button>Register</button>
        </form>
        <br>
    </div>

    <div style="border: 3px solid black; margin:5px; padding:5px ">
        <h2>Register</h2>
        <form action="/login" method="POST">
            @csrf
            <input placeholder="name" name="loginname" type="text">
            <input type="password" placeholder="password" name="loginpassword">
            <button>Login</button>
        </form>
        <br>
    </div>
    @endauth


</body>
</html>
