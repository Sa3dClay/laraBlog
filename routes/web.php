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
//override user mailer
Route::post('password/email','Mail_senderController@send_pass_link')->name('password.email');

// Admin
Route::get('admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.loginForm');
Route::get('admin/password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::get('admin/password/reset/{token}','Auth\ForgotPasswordController@showResetForm_admin')->name('admin.password.reset');
Route::post('admin/password/email','Mail_senderController@send_pass_link')->name('admin.password.email');
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
	// manage Feedbacks
	Route::get('/feedbacks', 'FeedbacksController@list');
	Route::get('/feedbacks/{id}/close', 'FeedbacksController@close');
	//Route::get('/feedbacks/{id}/mark_feedback', 'FeedbacksController@mark_feedback')->name('mark_feedback');
	//add response & mark responded feedback //Note: POST method requires a form to apply it
	Route::post('/feedbacks/respond/store', 'ResponseController@store')->name('storeResponse');
  // Notification
	Route::get('/notifications/send/{type}/{user_id}/{post_id}', 'NotificationsController@send');
	Route::get('/notifications/get_new_Notif', 'NotificationsController@get_new_Notif');
	Route::get('/notifications/index', 'NotificationsController@index');
	Route::get('/notifications/isThereNew', 'NotificationsController@isThereNew');
});

// User
Route::get('profile/{user}', 'UserController@show');

// Post
Route::resource('posts', 'PostsController');
Route::get('/post/search', 'PostsController@search');

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
Route::get('/notifications/send/{type}/{user_id}/{post_id}', 'NotificationsController@send')->middleware('auth');
Route::get('/notifications/get_new_Notif', 'NotificationsController@get_new_Notif')->middleware('auth');
Route::get('/notifications/index', 'NotificationsController@index')->middleware('auth'); // GET methods can be called by forms/url()/route()
Route::get('/notifications/isThereNew', 'NotificationsController@isThereNew')->middleware('auth'); // POST methods can be called by forms ONLY

//Feedbacks
Route::resource('feedbacks', 'FeedbacksController');

//Feedback's responses
Route::get('/feedbacks/{feedback_id}/{user_id}/responses', 'ResponseController@responses')->name('responses');
