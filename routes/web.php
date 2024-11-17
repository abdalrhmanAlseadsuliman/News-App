<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\CategoryPostController;
use App\Http\Controllers\Frontend\Dashboard\ProfileController;
use App\Http\Controllers\Frontend\NewSubscribeController;
use App\Http\Controllers\Frontend\PostsAndCommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/','/home');

Route::group([
    'as' => 'frontend.',
],function(){
    // Route::get('/home', [HomeController::class ,'index'])->name('index')->middleware('auth','verified');
    Route::get('/home', [HomeController::class ,'index'])->name('index');
    Route::post('news-subscribe',[NewSubscribeController::class ,'store'])->name('news.subscribe');
    Route::get('category/{slug}',CategoryPostController::class)->name('category.posts');

    Route::controller(PostsAndCommentController::class)->name('post.')->prefix('post')->group(function(){
        Route::get('post/comments/{slug}','getAllCommentsForPost')->name('getComments');
        Route::get('post/{slug}','show')->name('show');
        Route::post('post/comments/store','storeComment')->name('comments.store');
    });

    Route::prefix('user/')->name('dashboard.')->middleware(['auth:web','verified'])->group(function(){
        Route::controller(ProfileController::class)->group(function(){
            Route::get('profile','index')->name('profile');
        });
    });

    Route::controller(ContactController::class)->name('contact.')->prefix('contact-us')->group(function(){
       Route::get('/','index')->name('index');
       Route::post('/store','store')->name('store');
    });

    Route::match(['get','post'],'search',SearchController::class)->name('search');
});

Route::prefix('email')->name('verification.')->controller(VerificationController::class)->group(function(){
    Route::get('/verify', 'show')->name('notice');
    Route::get('/verify/{id}/{hash}', 'verify')->name('verify');
    Route::post('/resend', 'resend')->name('resend');
});

Route::get('test',function(){
    return view('frontend.dashboard.profile');
});

Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

