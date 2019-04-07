<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Models\Portfolio;
use App\Models\Page;
use App\Models\Post;
use App\Models\Category;


Route::domain(env('APP_BLOG_HOST'))->group(function () {
    Route::get('category/{category}/{post}', function (Category $category, Post $post) {
        return view('post.single', compact('category', 'post'));
    })->name('post.single');

    Route::get('/', function () {
        $posts = Post::where('status', '=', 'publish')->paginate();
        return view('post.index', compact('posts'));
    })->name('post.index');
});

Route::domain(env('APP_MAIN_HOST'))->group(function () {

    Route::group(['prefix' => 'admin'], function () {
        Voyager::routes();
    });

    Route::get('/', function () {
        return view('home', ['items' => []]);
    });

    Route::get('/{page}', function (Page $page) {
        return view('page', ['item' => $page]);
    });

    Route::get('portfolio/{item}', function(Portfolio $item) {
        return view('portfolio.single', ['item' => $item]);
    })->name('portfolio.single');
});

