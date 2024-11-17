<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $key_word = $request->search;
        // return $key_word;
        // $posts = Post::active()
        //         ->where('title','LIKE' , '%'. $key_word . '%')
        //         ->orWhere('description', 'LIKE' , '%'. $key_word . '%')
        //         ->paginate(16);
        $posts = Post::active() // تطبيق سكوب active
                ->where(function($query) use ($key_word) {
                    $query->where('title', 'LIKE', '%' . $key_word . '%')
                        ->orWhere('description', 'LIKE', '%' . $key_word . '%');
                })
                ->paginate(16);

        // return $posts;
        return view('frontend.search', compact('posts'));
    }
}
