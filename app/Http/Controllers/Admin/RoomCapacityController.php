<?php

namespace App\Http\Controllers\Admin;

use App\RoomCapacity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomCapacityRequest;

class RoomCapacityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $pagination;

    public function __construct(RoomCapacity $room_capacities)
    {
        $this->room_capacities = $room_capacities;
        $this->pagination   = env('PAGINATION', 25);
    }


    public function index()
    {
        $room_capacities = $this->room_capacities->paginate($this->pagination);
        return view('admin.room_capacity.index')->with('room_capacities', $room_capacities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return redirect()->route('roomcapacity.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomCapacityRequest $request)
    {
        $payload = $request->except('_token');
        $result = $this->room_capacities->create($payload);
        return response()->json([
            'success'   => true,
            'data'   => $result
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomCapacity  $roomCapacity
     * @return \Illuminate\Http\Response
     */
    public function show(RoomCapacity $roomCapacity)
    {
        return redirect()->route('roomcapacity.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomCapacity  $roomCapacity
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomCapacity $roomCapacity)
    {
        return redirect()->route('roomcapacity.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomCapacity  $roomCapacity
     * @return \Illuminate\Http\Response
     */
    public function update(RoomCapacityRequest $request, $id)
    {
        $payload = $request->except('_token');
        $result = $this->room_capacities->find($id)->update($payload);
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
     * @param  \App\RoomCapacity  $roomCapacity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->room_capacities->destroy($id);
    }
}
