<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    //

    public $fillable = [
    	'name',
    	'hotel_id',
    	'room_type_id',
    	'room_capacity_id',
    	'images'
    ];


    public function room_type()
    {
    	return $this->belongsTo(RoomTypes::class);
    }

    public function room_capacity()
    {
    	return $this->belongsTo(RoomCapacity::class);
    }

}
