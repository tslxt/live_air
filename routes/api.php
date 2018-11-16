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
// Route::group(['middleware' => 'auth:api'], function(){
// 	Route::put('update', 'UsersController@update');
// });
/*
 * for user
 */
Route::post('user_update', 'UsersController@update')->middleware('auth:api');

/*
 * for teacher
 */
Route::post('teachers', 'TeachersController@store')->middleware('auth:api');
Route::post('teacher_register', 'TeachersController@register')->middleware('auth:api');
Route::post('show', 'TeachersController@show')->middleware('auth:api');
/*
 * for public course
*/
Route::post('public_courses', 'PublicCoursesController@index')->middleware('auth:api');
Route::post('public_course/{id}', 'PublicCoursesController@show')->middleware('auth:api');
Route::post('public_course_create', 'PublicCoursesController@store')->middleware('auth:api');
Route::post('public_course_update/{public_course}', 'PublicCoursesController@update')->middleware('auth:api');
Route::post('public_course_delete/{public_course}', 'PublicCoursesController@delete')->middleware('auth:api');
Route::post('public_course_upload_courseware/{public_course}', 'PublicCoursesController@upload')->middleware('auth:api');

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
