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

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

// Post
Route::resource('posts', 'PostsController');
Route::post('/post/like', 'PostsController@like');
Route::post('/post/dislike', 'PostsController@dislike');
Route::get('/post/getWhoLike', 'PostsController@getWhoLike');

// Comment
Route::get('/comment/load', 'CommentsController@load');
Route::put('/comment/edit', 'CommentsController@edit');
Route::post('/comment/store', 'CommentsController@store');
Route::delete('/comment/delete', 'CommentsController@delete');

//notification
Route::post('/notifications/send', 'NotificationsController@send');
 Route::get('/notifications/index', 'NotificationsController@index');
