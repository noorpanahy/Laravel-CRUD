<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    protected $fillable = ['title', 'body', 'user_id', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // app/Models/Post.php
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}