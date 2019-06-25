<?php

use Illuminate\Http\Request;


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

// Create lInk of Storage Images

Auth::routes(['register' => false]);

Route::get('/admin', function () {
    return redirect('/login');
});


Route::group(['middleware' => ['auth']], function () {
	Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
		Route::get('dashboard', 'HomeController@index')->name('dashboard');

		Route::get('hotels', 'HotelController@index')->name('hotels');
		Route::get('hotels/{id}/edit', 'HotelController@edit')->name('hotel.edit');
		Route::get('hotels/{id}/preview', 'HotelController@show')->name('hotel.show');
		Route::post('hotels/delete/{id}', 'HotelController@destroy');
		Route::post('hotels/{id}', 'HotelController@update');
		Route::post('hotels', 'HotelController@store');
		Route::post('hotels/{id}/imageupload', 'HotelController@imageupload');

		Route::get('rooms', 'RoomsController@index')->name('rooms');
		Route::get('rooms/{id}/edit', 'RoomsController@edit')->name('room.edit');
		Route::get('rooms/{id}/preview', 'RoomsController@show')->name('room.show');
		Route::post('rooms/delete/{id}', 'RoomsController@destroy');
		Route::post('rooms/{id}', 'RoomsController@update');
		Route::post('rooms', 'RoomsController@store');
		Route::delete('rooms/{id}', 'RoomsController@destroy');
		Route::post('rooms/{id}/imageupload', 'RoomsController@imageupload');
		Route::delete('rooms/{id}/imageupload', 'RoomsController@deleteimage');

		Route::resource('roomcapacity', 'RoomCapacityController', ['except' => ['show']]);
		Route::resource('roomtypes', 'RoomTypesController', ['except' => ['show']]);
		Route::resource('roomprices', 'RoomPricesController', ['except' => ['show']]);
	});
});

Route::get('/{path?}', [
    'uses' => 'ReactController@show',
    'as' => 'react',
    'where' => ['path' => '.*']
]);

// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
