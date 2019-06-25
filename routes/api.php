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

Route::prefix('v1')->group(function(){
	Route::post('login', 'Api\AuthController@login');
	Route::group(['middleware' => 'auth:api'], function(){
		Route::get('getroomtypes', 'Api\BookingManager@room_types');
		Route::post('listrooms', 'Api\BookingManager@getrooms');
		Route::post('createreservation', 'Api\BookingManager@makereservation');
	});

	Route::get('room_types', 'Api\BookingManager@room_types');
	Route::post('getrooms', 'Api\BookingManager@getrooms');
	Route::post('makereservation', 'Api\BookingManager@makereservation');
});
