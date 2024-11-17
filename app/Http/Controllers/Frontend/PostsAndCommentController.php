<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsAndCommentController extends Controller
{
    public function show($slug)
    {
        $post = Post::whereSlug($slug)->first();

        // $mainPost = Post::with(['comments' => function ($query): void {
        //     $query->whereNull('parent_id') // جلب فقط التعليقات الأب
        //     ->with(['user', 'replies.user']) // جلب المستخدمين والردود
        //     ->get()
        //     ->map(function ($comment) {
        //         $comment->has_replies = $comment->replies->isNotEmpty();
        //         return $comment;
        //     });
        // }])->whereSlug($slug)->first();



        $mainPost = Post::with(['comments' => function ($query): void {
            $query->whereNull('parent_id') // جلب فقط التعليقات الأب
                  ->with(['user', 'replies.user']) // جلب المستخدمين والردود
                  ->latest()
                  ->get();
        }])->whereSlug($slug)->first();

        // إضافة الحقل `has_replies` بعد جلب النتائج
        $mainPost->comments->map(function ($comment) {
            $comment->has_replies = $comment->replies->isNotEmpty();
            return $comment;
        });

        // return response()->json($mainPost);

        // $postBelongToCategory = Post::where('category_id',$post->category->id)->get();
        $category = $mainPost->category;
        // $postBelongToCategory = $category->posts()->select('id','title','slug')->limit(10)->get();
        $postBelongToCategory = $category->posts()->select('id', 'title', 'slug')->inRandomOrder()->limit(10)->get();
        // $inThisCategory = $postBelongToCategory->inRandomOrder()->limit(15)->get();
        // $relatedPosts = $postBelongToCategory->inRandomOrder()->limit(15)->get();

        return view("frontend.show-post", compact("mainPost", "postBelongToCategory",'category'));
    }

    public function getAllCommentsForPost($slug)
    {
        $post = Post::whereSlug($slug)->first();
        // return $mainPosts;

        // $comments = $posts->comments()->with('user')->get();
        // $comments = $post->comments()
        //              ->whereNull('parent_id')  // جلب فقط التعليقات الأب
        //              ->with(['user', 'replies.user']) // جلب بيانات المستخدم والردود
        //              ->get();
        $comments = $post->comments()
            ->whereNull('parent_id') // جلب فقط التعليقات الأب
            ->with(['user', 'replies.user']) // جلب المستخدمين والردود
            ->get()
            ->map(function ($comment) {
                $comment->has_replies = $comment->replies->isNotEmpty();
                return $comment;
            });
        return response()->json($comments);
    }

    public function storeComment(Request $request){
        $request->validate([
            'user_id' => ['required','exists:users,id'],
            'post_id' => ['required','exists:posts,id'],
            'comment' => ['required','string','max:200'],
            'parent_id' => ['nullable', 'exists:comments,id']
        ]);

        $comment = Comment::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'parent_id' => $request->parant_id,
            'ip_address' => $request->ip(),
        ]);

        $comment->load('user');
        if (!$comment) {
            return response()->json([
                'data' => 'failed',
                'status' => 403
            ]);
        }
        return response()->json([
            'msg' => 'oky',
            'comment' => $comment,
            'status' => 201 // رمز إدخال البيانات بنجاح ضمن القاعدة
        ]);
    }
}
