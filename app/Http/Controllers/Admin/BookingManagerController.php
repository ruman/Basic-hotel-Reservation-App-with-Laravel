<?php

namespace App\Http\Controllers\Admin;

use App\Bookings;
use App\HotelData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $pagination;

    public function __construct(Bookings $bookings)
    {
        $this->bookings = $bookings;
        $this->pagination   = env('PAGINATION', 50);
    }


    public function index()
    {
        $bookings = $this->bookings->all();
        foreach ($bookings as &$booking) {
            $booking->hotel_name = $booking->hotel->name;
            $booking->room_name = $booking->room->name;
            $booking->room_type = $booking->room->room_type->name;
            $booking->room_capacity = $booking->room->room_capacity->name;
            $booking->customer = $booking->customer->first();

            $hoteldata = HotelData::where('hotel_id', $booking->hotel_id)
                            ->where('room_id', $booking->room_id)
                            ->first();
            if($hoteldata){
                $booking->rate = $hoteldata->price->rate;
            }
        }

        return view('admin.bookings.index')->with(compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bookings  $bookings
     * @return \Illuminate\Http\Response
     */
    public function show(Bookings $bookings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bookings  $bookings
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookings $bookings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bookings  $bookings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bookings $bookings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bookings  $bookings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bookings $bookings)
    {
        //
    }
}
