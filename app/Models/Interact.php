<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Interact extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_name',
        'type_code',
        'user_id',
        'post_id',
        'comment_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function comment(){
        return $this->belongsTo(Comment::class);
    }

}
