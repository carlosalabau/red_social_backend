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



Route::post('user/new', 'UserController@register');
Route::post('user/login', 'UserController@login');
Route::get('user/logout','UserController@logout');
Route::get('user/name/{id}', 'UserController@nameFollower');

Route::group([
    'prefix'=>'user',
    'middleware'=>'auth:api'
], function(){
    Route::get('/', 'UserController@index');
    Route::get('/user', 'UserController@getUser');
    Route::get('/search/{letter}', 'UserController@search');

});
Route::group([
    'prefix'=>'post',
    'middleware'=>'auth:api'
], function(){
    Route::get('/', 'PostController@index');
    Route::post('/like','PostController@like');
    Route::post('/dislike','PostController@dislike');
    Route::get('/perfil/{id}','PostController@getPostsPerfil');
    Route::post('/new','PostController@newPost');
});
Route::group([
    'prefix'=>'comment',
    'middleware'=>'auth:api'
], function(){
    Route::post('/new', 'CommentController@addComment');
    Route::get('/name/{id}','CommentController@getName');
});
Route::group([
    'prefix'=>'follow',
    'middleware'=>'auth:api'
], function(){
    Route::get('/{id}', 'PostController@allFollows');
});


//Route::apiResource('posts', 'PostController');

/*Route::middleware('auth:api')->group(function(){
    Route::get('users', 'UserController@index');
    Route::get('users/user', 'UserController@getUser');
    Route::post('posts/like','PostController@like');
    Route::get('users/logout','UserController@logout');
    Route::post('dislikes', 'PostController@dislikes');
});*/
