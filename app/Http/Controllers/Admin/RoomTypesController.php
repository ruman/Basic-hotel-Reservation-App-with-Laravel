<?php

namespace App\Http\Controllers\Admin;

use App\RoomTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $pagination;

    public function __construct(RoomTypes $room_types)
    {
        $this->room_types = $room_types;
        $this->pagination   = env('PAGINATION', 25);
    }


    public function index(Request $request)
    {
        $room_types = $this->room_types->paginate($this->pagination);
        return view('admin.room_types.index')->with('room_types', $room_types);
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
     * @param  \App\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function show(RoomTypes $roomTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomTypes $roomTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomTypes $roomTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomTypes $roomTypes)
    {
        //
    }
}
