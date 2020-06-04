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



Route::post('users/new', 'UserController@register');
Route::post('users/login', 'UserController@login');
Route::get('users/logout','UserController@logout');
Route::get('users/name/{id}', 'UserController@nameFollower');

Route::group([
    'prefix'=>'users',
    'middleware'=>'auth:api'
], function(){
    Route::get('/', 'UserController@index');
    Route::get('/user', 'UserController@getUser');
    Route::get('/search/{letter}', 'UserController@search');

});
Route::group([
    'prefix'=>'posts',
    'middleware'=>'auth:api'
], function(){
    Route::get('/', 'PostsController@index');
    Route::post('/like','PostsController@like');
    Route::post('/dislike','PostsController@dislike');
    Route::get('/coments/{id}', 'PostController@coments');
});
Route::group([
    'prefix'=>'coment',
    'middleware'=>'auth:api'
], function(){
    Route::post('/new', 'PostsController@addComent');
});
Route::group([
    'prefix'=>'follow',
    'middleware'=>'auth:api'
], function(){
    Route::get('/{id}', 'PostsController@allFollows');
});


//Route::apiResource('posts', 'PostsController');

/*Route::middleware('auth:api')->group(function(){
    Route::get('users', 'UserController@index');
    Route::get('users/user', 'UserController@getUser');
    Route::post('posts/like','PostsController@like');
    Route::get('users/logout','UserController@logout');
    Route::post('dislikes', 'PostsController@dislikes');
});*/
