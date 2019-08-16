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

Route::middleware('guest')->get('login', 'AuthController@login');
Route::post('login', 'AuthController@handleLogin');
Route::get('logout', 'AuthController@handleLogout');

Route::get('/{any}', function () {
    return view('spa');
})->where('any', '.*');