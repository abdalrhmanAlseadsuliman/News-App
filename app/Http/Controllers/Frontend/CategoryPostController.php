<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryPostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($slug)
    {
        $category = Category::where("slug", $slug)->firstOrFail();
        $posts = $category->posts()->orderBy("created_at","desc")->paginate(9);
        // $posts = $category->posts()->orderBy("created_at","desc")->get();
        return view("frontend.category-posts", compact("posts",'category'));
    }
}
