<?php

namespace App\Models;

use App\Models\Img;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Interact;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory,Sluggable;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'published_at',
        'comment_able',
        'user_id',
        'category_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }


    public function interacts(){
        return $this->hasMany(Interact::class);
    }

    public function images(){
        return $this->hasMany(Img::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function scopeActive($query)
    {
        $query->where('status', '=', 'active'); // أفضل استخدام '=' بدلاً من 'LIKE' في هذه الحالة
    }


}
