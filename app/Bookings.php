<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    //
	public $fillable = [
    	'hotel_id',
    	'room_id',
    	'check_in',
    	'check_out',
    	'customer_id'
    ];


    public function hotel()
    {
    	return $this->belongsTo(Hotels::class);
    }

    public function room()
    {
    	return $this->belongsTo(Rooms::class);
    }

    public function hoteldata()
    {
        return $this->belongsTo(HotelData::class, 'hotel_id', 'room_id');
    }

    public function customer()
    {
    	return $this->belongsTo(Customers::class);
    }

}
