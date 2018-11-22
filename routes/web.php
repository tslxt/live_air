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

Route::get('/', 'LivesController@index');
Route::get('/live', 'LivesController@index');
Route::get('/login', 'LivesController@index');
Route::get('/live/{course_id}', 'LivesController@index');
// Route::get('/live/{channel_id}', 'LivesController@show');

// // Route::get('/test', 'LivesController@test')->middleware('auth::api');
// Route::get('/test', 'LivesController@test');

// Route::get('/{any}', 'LivesController@index')->where('any', '.*');
