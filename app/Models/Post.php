<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //To get the owner of the Post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function create()
    {
        return view('posts.create');
    }
}
