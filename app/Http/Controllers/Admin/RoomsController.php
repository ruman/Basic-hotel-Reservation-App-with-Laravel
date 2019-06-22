<?php

namespace App\Http\Controllers\Admin;

use App\Hotels;
use App\Rooms;
use App\RoomTypes;
use App\RoomCapacity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $pagination;

    public function __construct(Hotels $hotels, Rooms $rooms, RoomTypes $room_types, RoomCapacity $room_capacities)
    {
        $this->hotels = $hotels;
        $this->rooms = $rooms;
        $this->room_types = $room_types;
        $this->room_capacities = $room_capacities;
        $this->pagination   = env('PAGINATION', 50);
    }


    public function index()
    {
        $rooms = $this->rooms->all();
        $hotels = $this->hotels->select('name','id')->get();
        $room_types = $this->room_types->select('name','id')->get();
        $room_capacities = $this->room_capacities->select('name','id')->get();
        return view('admin.rooms.index')->with(compact('rooms', 'hotels', 'room_types','room_capacitis'));
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
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function show(Rooms $rooms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function edit(Rooms $rooms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rooms $rooms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rooms $rooms)
    {
        //
    }
}
