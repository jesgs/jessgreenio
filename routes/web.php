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

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/', function () {
    $items = Portfolio::query()->orderBy('order')->paginate(6);
    return view('home', ['items' => $items]);
});

Route::get('/{page}', function (Page $page) {
    return view('page', compact('page'));
});

Route::get('portfolio/{item}', function(Portfolio $item) {
    return view('portfolio.single', ['item' => $item]);
})->name('portfolio.single');
