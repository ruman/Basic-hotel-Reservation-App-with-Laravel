<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\CheckRoomsRequest;
use App\Http\Requests\Api\CreateReservation;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\RoomTypes;
use App\Rooms;
use App\HotelData;
use App\Hotels;
use App\RoomPrices;
use App\Bookings;
use App\Customers;

class BookingManager extends Controller
{
    //

    function room_types()
    {
    	$room_types = RoomTypes::select('name', 'id')->get();

    	/*return response()->json([
    		'room_types'=> $room_types
    	]);*/

    	return response($room_types, 200);
    }

    public function getrooms(CheckRoomsRequest $request)
    {
    	$data = $request->all();
    	if (Carbon::now()->gt(Carbon::parse($data['from']))){
    		return response()->json([
				'success'=>false,
				'message'=> 'Please Select future date'
			]);
    	}
    	$rooms = Rooms::select('id')->where('room_type_id', '=', $data['roomtype'])->get();
    	if($rooms->count()){
    		$list = [];
    		foreach ($rooms as $room) {
    			$list[] = $room->id;
    		}
    		$result = HotelData::select('id','hotel_id', 'room_id', 'price_id', 'price_description')->where('date_start', '<=', $data['from'])
    				->where(function($query) use ($data) {
				        $query->where('date_end', '>=', $data['to'])
				            ->orWhereNull('date_end');
				    })
    				// ->where('date_end', '>=', $data['to'])
    				->whereIn('room_id',[1])
    				->get();
    		if($result){
    			foreach ($result as &$hoteldata) {
    				$hoteldata->rate = $hoteldata->price->rate;
    				$hoteldata->hotel_name = $hoteldata->hotel->name;
    				$hoteldata->room_name = $hoteldata->room->name;
    				unset($hoteldata->hotel);
    				unset($hoteldata->room);
    				unset($hoteldata->price);
    			}
    			return response()->json([
    				'success'=>true,
    				'result'=>$result
    			]);
    		}
    	}
		return response()->json([
			'success'=>false,
			'message'=> 'No Rooms Available. Please try different dates'
		]);
    }

    public function makereservation(CreateReservation $request)
    {
    	$data = $request->all();
    	/*$data = $request->validate([
    		'hotel_id'	=> 'required',
    		'room_id'	=> 'required',
    		'check_in'	=> 'required',
    		'check_out'	=> 'required',
    		'first_name'=> 'required',
    		'last_name'	=> 'required',
    		'address'	=> 'required',
    		'city'	=> 'required',
    		'country'	=> 'required',
    		'phone'	=> 'required',
    		'email'	=> 'required|email',
    	]);*/
    	$customerdata = [
    		'first_name'  => $data['first_name'],
            'last_name'  => $data['last_name'],
            'address'  => $data['address'],
            'city'  => $data['city'],
            'country'  => $data['country'],
            'phone'  => $data['phone'],
            'email'  => $data['email'],
    	];
    	// dd($customerdata);
    	$createcustomer = Customers::create($customerdata);
    	if($createcustomer){
    		$checkin = Carbon::create($data['check_in']);
    		$checkout = Carbon::create($data['check_out']);
    		$reservationdata = [
    			'hotel_id'	=> $data['hotel_id'],
    			'room_id'	=> $data['room_id'],
    			'check_in'	=> $checkin,
    			'check_out'	=> $checkout,
    			'customer_id'	=> $createcustomer->id,
    		];
    		$makereservation = Bookings::create($reservationdata);
    		if($makereservation){
    			return response()->json([
					'success'=> true,
					'message'=> 'Reservation Success. Booking ID: '.$makereservation->id
				]);
    		}
    	}

    	return response()->json([
			'success'=>false,
			'message'=> 'Reservation Failed. Please try again later.'
		]);

    }
}
