<?php

namespace App\Http\Controllers\Admin;

use App\Hotels;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PragmaRX\Countries\Package\Countries;

use App\Http\Requests\HotelCreateRequest;
use App\Http\Requests\HotelImageUploadRequest;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $pagination;

    public function __construct(Hotels $hotels)
    {
        $this->hotels = $hotels;
        $this->pagination   = env('PAGINATION', 50);
    }

    public function index(Request $request)
    {
        $hotels = $this->hotels->paginate($this->pagination);
        $countries = Countries::all()->pluck('name.common', 'postal');
        // $states = Countries::where('cca3', 'USA')->first()->hydrateStates()->states->pluck('name', 'postal');
        // $cities = Countries::where('cca3', 'USA')->first()->hydrate('cities')->cities->where('adm1name', 'New York')->pluck('name');
        // dd($cities);
        // $all = $countries->all();
        /*foreach ($cities as $city) {
            echo $city['name'].'<br/><br/>';
        }*/
        return view('admin.hotels.index')->with(compact('hotels','countries'));
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
    public function store(HotelCreateRequest $request)
    {
        $payload = $request->except('_token', 'hotelimage');
        $result = $this->hotels->create($payload);

        if($request->file('hotelimage')){
            $image = $request->file('hotelimage');
            $name = $image->getClientOriginalName();
            $image->move(public_path().'/images/'.$result->id.'/', $name);  

            $result->image = $name;
            $result->save();
            $imageurl = asset('/images/'.$result->id.'/'.$name);
        }else {
            $imageurl = false;
        }

        return response()->json([
            'success'   => true,
            'data'   => [
                'id'        => $result->id,
                'name'      => $result->name,
                'address'   => $result->address,
                'city'      => $result->city,
                'state'     => $result->state,
                'country'   => $result->country,
                'phone'     => $result->phone,
                'email'     => $result->email,
                'image'     => $imageurl
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hotels  $hotels
     * @return \Illuminate\Http\Response
     */
    public function show(Hotels $hotels)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hotels  $hotels
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotels $hotels)
    {
        //
        return 'Edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hotels  $hotels
     * @return \Illuminate\Http\Response
     */
    public function update(HotelCreateRequest $request, $id)
    {
        $payload = $request->except('_token');
        $result = $this->hotels->find($id)->update($payload);
        $hotelinfo = $this->hotels->find($id);
        if($result){
            return response()->json([
                'success'=> true,
                'message'   => 'Hotel Updated',
                'data'      => $hotelinfo
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
     * @param  \App\Hotels  $hotels
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotels $hotels)
    {
        //
    }

    public function imageupload(HotelImageUploadRequest $request)
    {        
        if($request->hasfile('hotelimage'))
         {
            $hotel_id = $request->input('hotel_id');
            $image = $request->file('hotelimage');
            $name = $image->getClientOriginalName();
            $image->move(public_path().'/images/'.$hotel_id.'/', $name);  
            
            $hotelinfo = $this->hotels->find($hotel_id);
            // dd($hotelinfo);
            $hotelinfo->image = $name;
            $hotelinfo->save();
            $imageurl = asset('/images/'.$hotel_id.'/'.$name);

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
}
