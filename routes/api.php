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

Route::get('post', 'API\PostController@index');
Route::get('post/{post}', 'API\PostController@show');

Route::middleware('auth:api')->group(function() {
    Route::get('author/me', 'API\AuthorController@showMe');

    Route::post('post', 'API\PostController@store');
    Route::put('post/{post}', 'API\PostController@update');
    Route::delete('post/{post}', 'API\PostController@destroy');
});
