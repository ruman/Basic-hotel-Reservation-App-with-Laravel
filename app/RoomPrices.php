<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomPrices extends Model
{
    public $fillable = [
    	'name',
		'room_id',
		'rate',
		'rate_info',
		'start_date',
		'end_date'
    ];


}
