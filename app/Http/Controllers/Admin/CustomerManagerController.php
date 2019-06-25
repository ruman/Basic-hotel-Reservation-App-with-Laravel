<?php

namespace App\Http\Controllers\Admin;

use App\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PragmaRX\Countries\Package\Countries;

use App\Http\Requests\CustomerManagerRequest;

class CustomerManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $pagination;

    public function __construct(Customers $customers)
    {
        $this->customers = $customers;
        $this->pagination   = env('PAGINATION', 50);
    }

    public function index(Request $request)
    {
        $customers = $this->customers->paginate($this->pagination);
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
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show(Customers $customers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function edit(Customers $customers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customers $customers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customers $customers)
    {
        //
    }
}
