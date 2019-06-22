<?php

namespace App\Http\Controllers\Admin;

use App\RoomTypes;
use Illuminate\Http\Request;
use App\Http\Requests\RoomTypesRequest;
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


    public function index()
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
    public function store(RoomTypesRequest $request)
    {
        $payload = $request->except('_token');
        $result = $this->room_types->create($payload);
        return response()->json([
            'success'   => true,
            'data'   => $result
        ]);
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
    public function update(RoomTypesRequest $request, $id)
    {
        $payload = $request->except('_token');
        $result = $this->room_types->find($id)->update($payload);
        if($result){
            return response()->json([
                'success'=> true,
                'data'   => $request->input('name')
            ]);
        }
        
        return response()->json([
            'success'=> false,
            'message'   => 'Failed to Update'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->room_types->destroy($id);
    }
}
