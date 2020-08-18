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

// User
Auth::routes();

// Admin
Route::get('admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.loginForm');
Route::post('admin/login', 'Auth\AdminLoginController@login')->name('admin.login');
Route::post('admin/logout','Auth\AdminLoginController@logout')->name('admin.logout');

Route::group(['prefix' => 'admin', 'middleware' => 'assign.guard:admin,admin/login'], function()
{
	// manage home
	Route::get('/home', 'AdminController@index');
	// manage users
	Route::get('/users', 'AdminController@listUsers');
	Route::post('/blockUser', 'AdminController@blockUser');
	Route::post('/revokeUser/{user}', 'AdminController@revokeUser');
	Route::delete('/deleteUser/{user}', 'AdminController@deleteUser');
	// manage posts
	Route::post('/hidePost', 'AdminController@hidePost');
	Route::get('/posts', 'AdminController@listHiddenPosts');
	Route::post('/showPost/{post}', 'AdminController@showPost');
});

// Post
Route::resource('posts', 'PostsController');
Route::post('/post/search', 'PostsController@search');
// Like
Route::post('/post/like', 'PostsController@like');
Route::post('/post/dislike', 'PostsController@dislike');
Route::get('/post/getWhoLike', 'PostsController@getWhoLike');

// Comment
Route::get('/comment/load', 'CommentsController@load');
Route::put('/comment/edit', 'CommentsController@edit');
Route::post('/comment/store', 'CommentsController@store');
Route::delete('/comment/delete', 'CommentsController@delete');

// Notification
Route::get('/notifications/send/{type}/{user_id}/{post_id}', 'NotificationsController@send');
Route::get('/notifications/get_new_Notif', 'NotificationsController@get_new_Notif');
Route::post('/notifications/isThereNew', 'NotificationsController@isThereNew');
Route::get('/notifications/index', 'NotificationsController@index');
