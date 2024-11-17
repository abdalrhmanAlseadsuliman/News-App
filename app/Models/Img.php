<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Img extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'post_id',
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
