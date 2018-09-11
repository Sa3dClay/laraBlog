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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

/*
Route::get('/users/{name}/{id}', function ($name, $id) {
	return 'User Name is: ' . $name . ', with an id: ' . $id;
});
*/

/*
Route::get('/hello', function () {
    return '<p style="text-align: center; margin-top: 300px; font-size: 40px; color: #636b6f; font-family: "Raleway", sans-serif;">Hello world!</p>';
});
*/

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

Route::resource('posts', 'PostsController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/like', 'PostsController@like')->name('like');