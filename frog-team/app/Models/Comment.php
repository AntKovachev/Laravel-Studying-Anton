<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function post() //post_id
    {
        return $this->belongsTo(Post::class);
    }

    public function author() //author_id, but we specify that its user_id
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
