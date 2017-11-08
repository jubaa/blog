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

// routes for home
Route::get('/' , 'HomeController@index');
Route::get('/home' , 'HomeController@index')->name('home');

// routes for posts
Route::prefix('posts')->group(function () {
    Route::get('/',  'PostsController@index')->name('posts');
    Route::get('/create',  'PostsController@create')->name('posts.create');
    Route::post('/store',  'PostsController@store')->name('posts.store');
    Route::get('/show/{id}',  'PostsController@show')->name('posts.show');
    Route::get('/edit/{id}',  'PostsController@edit')->name('posts.edit');
    Route::post('/update/{id}',  'PostsController@update')->name('posts.update');
    Route::delete('/{id}',  'PostsController@destroy')->name('post.destroy');

});

// routes for comments
Route::prefix('comments')->group(function () {
    Route::post('/store/{post_id}',  'CommentsController@store')->name('comments.store');

    Route::get('/store/{post_id}',  'PostsController@show');
});

// routes for user
Route::prefix('users')->group(function () {
    Route::get('/profile/{id}' , 'UsersController@profile')->name('users.profile');
    Route::post('/update_avatar/{id}' , 'UsersController@update_avatar')->name('user.update_avatar');
});

Auth::routes();