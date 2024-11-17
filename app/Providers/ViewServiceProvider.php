<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Category;
use App\Models\RelatedSite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!Cache::has("latestPosts")) {
            $latestPosts = Post::select('id', 'title', 'slug')->latest()->limit(5)->get();
            Cache::remember('latestPosts', 3600, function () use ($latestPosts) {
                return $latestPosts;
            });
        }

        $latestPosts = Cache::get('latestPosts');
        $relatedSite = RelatedSite::select('name', 'url')->get();
        $categories = Category::select('id', 'name', 'slug')->get();
        $popularPosts = Post::withCount(['comments', 'interacts'])
            ->orderByDesc(DB::raw('comments_count + interacts_count'))
            ->limit(5)
            ->get();


        view()->share([
            'latestPosts' => $latestPosts,
            'relatedSite' => $relatedSite,
            'categories' => $categories,
            'popularPosts' => $popularPosts,
        ]);
    }
}
