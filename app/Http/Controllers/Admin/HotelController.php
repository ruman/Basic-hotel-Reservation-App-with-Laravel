<?php

namespace App\Http\Controllers\Admin;

use App\Hotels;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PragmaRX\Countries\Package\Countries;

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
        $this->pagination   = env('PAGINATION', 25);
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, Hotels $hotels)
    {
        //
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
}
