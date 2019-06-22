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

}
