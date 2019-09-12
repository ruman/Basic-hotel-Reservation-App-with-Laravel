<?php

namespace App\Http\Controllers\Admin;

use App\Customers;
use App\Bookings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PragmaRX\Countries\Package\Countries;

use Carbon\Carbon;

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
        return view('admin.customers.index')->with(compact('customers','countries'));
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
    public function show(Request $request, $id)
    {
        $result = Customers::find($id);
        $bookings = Bookings::where('customer_id','=', $id)->get();
        if($bookings->count()):
            foreach ($bookings as &$booking) {
                $booking->hotel = Bookings::find($booking->id)->hotel()->first()->name;
                $booking->room = Bookings::find($booking->id)->room()->first()->name;
                $booking->type = Bookings::find($booking->id)->room()->first()->room_type()->first()->name;
                $booking->capacity = Bookings::find($booking->id)->room()->first()->room_capacity()->first()->name;
                $booking->check_in = Carbon::parse($booking->check_in)->format('Y/m/d');
                $booking->check_out = Carbon::parse($booking->check_out)->format('Y/m/d');
                $booking->created = Carbon::parse($booking->updated_at)->format('Y/m/d h:m:s');
            }
        else:
            $bookings = false;
        endif;

        if($result):
            $result['bookings'] = $bookings;
            return response()->json([
                'success'   => true,
                'customer'  => $result
            ]);
        else:
            return response()->json([
                'success'   => false,
                'message'   => 'Information not Found!!!',
            ]);
        endif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $result = Customers::find($id);
        $bookings = Bookings::where('customer_id','=', $id)->get();
        if($bookings->count()):
            foreach ($bookings as &$booking) {
                $booking->hotel = Bookings::find($booking->id)->hotel()->first()->name;
                $booking->room = Bookings::find($booking->id)->room()->first()->name;
                $booking->type = Bookings::find($booking->id)->room()->first()->room_type()->first()->name;
                $booking->capacity = Bookings::find($booking->id)->room()->first()->room_capacity()->first()->name;
                $booking->check_in = Carbon::parse($booking->check_in)->format('Y/m/d');
                $booking->check_out = Carbon::parse($booking->check_out)->format('Y/m/d');
                $booking->created = Carbon::parse($booking->updated_at)->format('Y/m/d h:m:s');
            }
        else:
            $bookings = false;
        endif;

        if($result):
            $result['bookings'] = $bookings;
            return response()->json([
                'success'   => true,
                'customer'  => $result
            ]);
        else:
            return response()->json([
                'success'   => false,
                'message'   => 'Information not Found!!!',
            ]);
        endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payload = $request->except('_token', 'email');
        $result = $this->customers->find($id)->update($payload);
        $customerinfo = $this->customers->find($id);
        if($result){
            return response()->json([
                'success'=> true,
                'message'   => 'Customer Updated',
                'data'      => $customerinfo
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
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }
}
