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

// Route::middleware('auth:api')->get('details', 'UsersController@details');

