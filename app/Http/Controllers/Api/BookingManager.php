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
use App\RoomCapacity;
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
    				// ->whereIn('room_id',[1])
    				->get();
    		if($result->count()){
    			foreach ($result as &$hoteldata) {
    				$hoteldata->rate = $hoteldata->price->rate;
    				$hoteldata->hotel_name = $hoteldata->hotel->name;
    				if($hoteldata->hotel->image)
    					$hoteldata->hotel_image = asset('/images/'.$hoteldata->hotel_id.'/'.$hoteldata->hotel->image);
    				else
    					$hoteldata->hotel_image = false;

    				$hoteldata->room_name = $hoteldata->room->name;
    				$roomimages = $hoteldata->room->images;
    				if($roomimages && !empty($roomimages)){
    					$listroomimages = [];
    					$roomimages = json_decode( $roomimages );
    					foreach ($roomimages as $image) {
    						$listroomimages[] = asset('/storage/rooms/'.$hoteldata->room_id.'/'.$image);
    					}
    					$hoteldata->room_images = $listroomimages;
    				}else {
    					$hoteldata->room_images = false;
    				}
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
        /*
            Check Customer Exists or not with E-mail Address
        */
        $customer = Customers::where('email','=',$data['email'])->first();
        if(!$customer){
            $customer = Customers::create($customerdata);
        }
    	
    	if($customer){
    		$checkin = Carbon::create($data['check_in']);
    		$checkout = Carbon::create($data['check_out']);
    		$reservationdata = [
    			'hotel_id'	=> $data['hotel_id'],
    			'room_id'	=> $data['room_id'],
    			'check_in'	=> $checkin,
    			'check_out'	=> $checkout,
    			'customer_id'	=> $customer->id,
    		];
    		$makereservation = Bookings::create($reservationdata);
    		if($makereservation){
    			return response()->json([
					'success'=> true,
					'id'	=> $makereservation->id,
					'message'=> 'Reservation Success. Booking ID: '.$makereservation->id
				]);
    		}
    	}

    	return response()->json([
			'success'=>false,
			'message'=> 'Reservation Failed. Please try again later.'
		]);

    }

    public function reservation_details(Request $request)
    {
    	$id = $request->input('id');
    	$reservation = Bookings::find($id);
    	if($reservation){
    		$hoteldata = HotelData::where('room_id','=', $reservation->room->id)
    						->where('hotel_id', '=', $reservation->hotel->id)
    						->first();
    						$roomprice = RoomPrices::where('id','=', $hoteldata->price_id)->first();
    		$roomtype = RoomTypes::where('id', $reservation->room->room_type_id)->first();
    		$roomcapacity = RoomCapacity::where('id', $reservation->room->room_capacity_id)->first();
    		// dd($hoteldata);
    		if($hoteldata->hotel->image)
				$hoteldata->hotel_image = asset('/images/'.$hoteldata->hotel_id.'/'.$hoteldata->hotel->image);

			$roomimages = $hoteldata->room->images;
			$listroomimages = [];
			if($roomimages && !empty($roomimages)){
				$roomimages = json_decode( $roomimages );
				foreach ($roomimages as $image) {
					$listroomimages[] = asset('/storage/rooms/'.$hoteldata->room_id.'/'.$image);
				}
			}
			$customer = Customers::find($reservation->customer_id)->first();
    		$data = [
    			'hotel_name'		=> $reservation->hotel->name,
    			'hotel_image'		=> $hoteldata->hotel_image,
    			'room_name'			=> $reservation->room->name,
    			'room_images'		=> json_encode($listroomimages),
    			'room_type'			=> $roomtype->name,
    			'price'				=> $roomprice->rate,
    			'room_capacity'		=> $roomcapacity->name,
    			'customer_info'		=> [
    				'name'			=> $customer->first_name.' '.$customer->last_name,
    				'email'			=> $customer->email,
    				'address'		=> $customer->address,
    				'city'			=> $customer->city,
    				'country'		=> $customer->country,
    				'phone'			=> $customer->phone,
    				'fax'			=> $customer->fax,
    			]
    		];
    		return response()->json([
    			'success'	=> true,
    			'result'	=> $data
    		]);
    	}else {
    		return response()->json([
    			'success'	=> false,
    			'message'	=> 'Reservation not found!!!'
    		]);
    	}
    }
}
