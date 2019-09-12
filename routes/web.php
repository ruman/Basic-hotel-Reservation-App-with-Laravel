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
		Route::group(['prefix' => 'hotels'], function () {
			Route::get('/', 'HotelController@index')->name('hotels');
			Route::get('{id}/edit', 'HotelController@edit')->name('hotel.edit');
			Route::get('{id}/preview', 'HotelController@show')->name('hotel.show');
			Route::post('delete/{id}', 'HotelController@destroy');
			Route::post('{id}', 'HotelController@update');
			Route::post('/', 'HotelController@store');
			Route::post('{id}/imageupload', 'HotelController@imageupload');

			Route::get('getreservations', 'BookingManagerController@getallbookings');
		});

		Route::get('hotels/{id}/rooms', 'HotelController@rooms')->name('hotel.rooms');
		Route::post('hotels/{id}/rooms', 'HotelController@store_room');
		Route::post('hotels/{id}/rooms/{room_id}', 'HotelController@update_room');

		Route::get('rooms', 'RoomsController@index')->name('rooms');
		Route::get('rooms/{id}/edit', 'RoomsController@edit')->name('room.edit');
		Route::get('rooms/{id}/preview', 'RoomsController@show')->name('room.show');
		Route::post('rooms/delete/{id}', 'RoomsController@destroy');
		Route::post('rooms/{id}', 'RoomsController@update');
		Route::post('rooms', 'RoomsController@store');
		Route::delete('rooms/{id}', 'RoomsController@destroy');
		Route::post('rooms/{id}/imageupload', 'RoomsController@imageupload');
		Route::delete('rooms/{id}/imageupload', 'RoomsController@deleteimage');

		Route::resource('roomcapacity', 'RoomCapacityController', ['except' => ['show', 'delete']]);
		Route::resource('roomtypes', 'RoomTypesController', ['except' => ['show', 'delete']]);
		Route::resource('roomprices', 'RoomPricesController', ['except' => ['show', 'delete']]);
		Route::resource('bookings', 'BookingManagerController', ['except' => ['show', 'create','store']]);
		Route::resource('customers', 'CustomerManagerController', ['except' => ['create','store', 'delete']]);

		Route::get('tmpls/{path?}', function(Request $request){
			$path = $request->getPathInfo();
			$path = str_replace('/admin/tmpls/', '', $path);
			$path = str_replace('.html', '', $path);
			return view('admin.tmpls.'.$path);
		});
	});
});

Route::get('/{path?}', [
    'uses' => 'ReactController@show',
    'as' => 'react',
    'where' => ['path' => '.*']
]);

// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
