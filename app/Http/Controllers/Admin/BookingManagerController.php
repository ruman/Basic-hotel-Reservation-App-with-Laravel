<?php

namespace App\Http\Controllers\Admin;

use App\Bookings;
use App\HotelData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

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

        $date = [
            'start' => 1561730192,
            'end' => 1561734192,
        ];

        return view('admin.bookings.index')->with(compact('bookings', 'date'));
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

    public function getallbookings(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        if(isset($start) && isset($end)){

            $result = $this->bookings->whereBetween('check_in', [$start, $end])->get();

            if($result->count() > 0){
                $data = [];
                foreach ($result as $booking) {
                    $data[] = [
                        'id'        => $booking->id,
                        'title'     => $booking->customer->first_name.' '.$booking->customer->last_name,
                        // 'title'     => $booking->id,
                        'start'     => Carbon::create($booking->check_in)->format('Y-m-d h:m:s'),
                        'end'       => Carbon::create($booking->check_out)->format('Y-m-d h:m:s'),
                        'hotel'    => $booking->hotel->name,
                        'room'          => $booking->room->name,
                        'rate'          => $booking->hoteldata->price->rate,
                        /*'start'     => $booking->check_in,
                        'end'       => $booking->check_out,*/
                    ];
                }
                if(!empty($data)){
                    return response()->json($data);
                }
            }

        }

        return response()->json([
            'success'   => false,
            'message'   => 'Failed to Process'
        ]);
    }
}
