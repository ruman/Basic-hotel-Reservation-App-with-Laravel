<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    //

    public $timestamps = true;

    public $fillable = [
    	'id',
    	'adddress',
    	'city',
    	'country',
    	'zipcode',
    	'phone',
    	'email',
    	'image'
    ];

    public function rooms(){
    	return $this->hasMany(Rooms::class);
    }

    public function prices(){
    	return $this->hasMany(RoomPrices::class);
    }

    public function bookings(){
    	return $this->hasMany(Bookings::class);
    }

}