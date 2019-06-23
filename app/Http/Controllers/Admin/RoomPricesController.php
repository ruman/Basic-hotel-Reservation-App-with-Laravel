<?php

namespace App\Http\Controllers\Admin;

use App\RoomPrices;
use App\Rooms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomPricesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $pagination;

    public function __construct(RoomPrices $room_prices)
    {
        $this->room_prices = $room_prices;
        $this->pagination   = env('PAGINATION', 50);
    }

    public function index()
    {
        $room_prices = $this->room_prices->paginate($this->pagination);
        $rooms = Rooms::all();
        dd($rooms);
        // $room = $this->room_prices->find(1)->room();
        // foreach ($room_prices as $roomprice) {
        //     $room = $this->room_prices->room();
        // }
        return view('admin.room_prices.index')->with('room_prices', $room_prices);
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
     * @param  \App\RoomPrices  $roomPrices
     * @return \Illuminate\Http\Response
     */
    public function show(RoomPrices $roomPrices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomPrices  $roomPrices
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomPrices $roomPrices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomPrices  $roomPrices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomPrices $roomPrices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomPrices  $roomPrices
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomPrices $roomPrices)
    {
        //
    }
}
