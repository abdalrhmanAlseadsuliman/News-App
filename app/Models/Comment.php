<?php

namespace App\Models;

use App\Models\Interact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'ip_address',
        'post_id',
        'user_id',
        'parent_id',
    ];



    // علاقة "تعليق" مع "منشور"
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // علاقة "تعليق" مع "مستخدم"
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة "تعليق" مع "التعليق الأب"
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // علاقة "تعليق" مع "التعليقات الفرعية"
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function interacts(){
        return $this->hasMany(Interact::class);
    }
}
