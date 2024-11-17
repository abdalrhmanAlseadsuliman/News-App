<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        // Bring all articles sorted from newest to oldest with paginate
        $posts = Post::with('images')->latest()->paginate(9);
        // $latest_three_post = Post::latest()->take(3)->get();

        // most views
        $gretest_posts_views = Post::orderBy('num_of_views','desc')->limit(3)->get();
        //  oldest post
        $oldest_news = Post::oldest()->take(3)->get();

        // $gretest_posts_comment = Post::withCount('comments')->take(3)->get();

        // $popularPosts = Post::withCount(['comments', 'interacts'])
        //     ->orderByDesc(DB::raw('comments_count + interacts_count'))
        //     ->limit(3)
        //     ->get();

        $categories = Category::all();
        $categories_with_Post = $categories->map(function($category){
            $category->posts = $category->posts()->limit(4)->get();
            return $category;
        });
        // return $categories_with_Post;
        return view('frontend.index',compact('posts','gretest_posts_views' ,'oldest_news' ,'categories_with_Post'));
    }
}
