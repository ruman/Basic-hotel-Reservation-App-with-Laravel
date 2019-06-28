<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    //

    public $timestamps = true;

    public $fillable = [
    	'name',
    	'address',
    	'city',
    	'state',
    	'country',
    	'zipcode',
    	'phone',
    	'email',
    	'image'
    ];

    public function rooms(){
    	return $this->hasMany(HotelData::class, 'hotel_id', 'id');
    }

    public function prices(){
    	return $this->belongsTo(RoomPrices::class);
    }

    public function bookings(){
    	return $this->belongsTo(Bookings::class);
    }

}