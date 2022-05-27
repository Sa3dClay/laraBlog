<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//for api authentication
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Notification
Route::get('/notifications/{user_id}/index_userN_api', 'NotificationsController@index_userN_api');
