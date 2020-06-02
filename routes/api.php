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

Route::apiResource('posts', 'PostsController');
//Route::apiResource('users', 'UserController');
Route::post('users/new', 'UserController@register');
Route::post('users/login', 'UserController@login')->name('login');
Route::middleware('auth:api')->group(function(){
    Route::get('users', 'UserController@index');
    Route::get('users/user', 'UserController@getUser');
    Route::post('posts/like','PostsController@like');
});

