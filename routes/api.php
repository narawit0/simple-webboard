<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'

], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::get('/posts', 'PostController@index');
Route::get('/posts/{post}', 'PostController@show');
Route::post('/posts', 'PostController@store');
Route::get('/channels', 'ChannelController@index');
Route::get('/posts/channels/{channel}', 'ChannelController@show');
Route::post('/posts/{post}/comments', 'CommentController@store');
Route::delete('/posts/{post}', 'PostController@destroy');
Route::delete('/comments/{comment}', 'CommentController@destroy');
Route::put('/posts/{post}', 'PostController@update');
Route::put('/comments/{comment}', 'CommentController@update');
