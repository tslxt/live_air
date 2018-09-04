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
Route::get('basicusers', 'BasicUserController@index');
Route::get('basicusers/{id}', 'BasicUserController@show');
Route::post('basicusers', 'BasicUserController@store');
Route::put('basicusers/{basicUser}', 'BasicUserController@update');
Route::delete('basicusers/{basicUser}', 'BasicUserController@delete');
