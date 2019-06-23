<?php

namespace App\Http\Controllers\Admin;

use App\Hotels;
use App\Rooms;
use App\RoomTypes;
use App\RoomCapacity;
use Illuminate\Http\Request;
use App\Http\Requests\RoomImageUploadRequest;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

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
        foreach ($rooms as &$room) {
            $room_type= $this->room_types->find($room->room_type_id);
            $room->type = $room_type->name;
            $room_capacity= $this->room_capacities->find($room->room_capacity_id);
            $room->capacity = $room_capacity->name;
        }
        $room_types = $this->room_types->select('name','id')->get();
        $room_capacities = $this->room_capacities->select('name','id')->get();
        return view('admin.rooms.index')->with(compact('rooms', 'room_types','room_capacities'));
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


    public function imageupload(RoomImageUploadRequest $request)
    {        
        if($request->hasfile('room_image'))
         {
            $room_id = $request->input('room_id');
            $image = $request->file('room_image');
            $name = $image->getClientOriginalName();
            Storage::disk('local')->putFileAs('rooms', $image, $name);
            // $image->move(public_path().'/storage/rooms/'.$room_id.'/', $name);  
            
            $room = $this->rooms->find($room_id);
            if(!$room){
               return response()->json([
                    'success'   => false,
                    'message'   => 'Faled to Upload.Please Reload the page and try again'
                ]); 
            }
            $images = [];
            if($room->images && $room->images !='')
                $images = json_decode($room->images);
            $images[] = $name;
            $room->images = json_encode($images);
            $room->save();
            $imageurl = asset('storage/rooms'.$room_id.'/'.$name);

            return response()->json([
                'success'   => true,
                'url'   => $imageurl
            ]);
         }

         return response()->json([
            'success'   => false,
            'message'   => 'Faled to Upload.Please Reload the page and try again'
        ]);
    }

    public function deleteimage(Request $request, $id)
    {
        if($request->input('imageurl')){
            $image = $request->input('imageurl');
            $room = $this->rooms->findOrFail($id);
            if($room->images){
                $roomimages = json_decode($room->images);
                if(in_array($image, $roomimages)){
                    $key = array_search($image, $roomimages);                    
                    if(Storage::disk('local')->delete('rooms/'.$image)){
                        unset($roomimages[$key]);
                    }
                }

                $room->images = json_encode($roomimages);
                $room->save();
                return response()->json([
                    'success'   => true,
                    'image'   => $room->images
                ]);
            }
        }
        return response()->json([
            'success'   => false,
            'message'   => 'Operation Failed!!!'
        ]); 
    }
}
