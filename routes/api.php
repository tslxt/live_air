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
/*
 *verify sms code
*/
Route::post('verifysms', 'SmsVerifyController@verify');
/*
 *for password
*/

Route::post('validatePhone', 'UsersController@validatePhone');
Route::post('validateCode', 'UsersController@validateCode');
Route::post('loginCode', 'UsersController@loginCode');

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('details', 'UsersController@details');
});
/*
 * for teacher
 */
Route::post('teachers', 'TeachersController@store')->middleware('auth:api');
Route::post('show', 'TeachersController@show')->middleware('auth:api');
/*
 * for course
*/
Route::get('courses', 'CoursesController@index');
Route::get('courses/{id}', 'CoursesController@show');
Route::get('courses/{course}/lessons', 'CoursesController@lessons');
Route::post('courses', 'CoursesController@store');
Route::put('courses/{course}', 'CoursesController@update');
Route::delete('courses/{course}', 'CoursesController@delete');

/*
 * for lesson
*/
Route::get('lessons', 'LessonsController@index');
Route::get('lessons/{id}', 'LessonsController@show');
Route::post('lessons', 'LessonsController@store');
Route::put('lessons/{lesson}', 'LessonsController@update');
Route::delete('lessons/{lesson}', 'LessonsController@delete');
/*
* for image upload
*/
Route::post('images/upload', 'UserImageController@update');
Route::post('images/bitmap', 'UserImageController@bitmap');
Route::post('images/vision', 'UserImageController@vision');
Route::get('images/env', 'UserImageController@env');
