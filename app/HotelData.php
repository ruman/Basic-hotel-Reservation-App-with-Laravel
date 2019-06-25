<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelData extends Model
{
    //

    public $table = 'hotel_data';

    public $fillable = [
    	'hotel_id',
    	'room_id',
    	'price_id',
    	'state_date',
    	'end_date'
    ];

    public function hotel(){
    	return $this->belongsTo(Hotels::class);
    }

    public function room(){
    	return $this->belongsTo(Rooms::class);
    }

    public function price(){
    	return $this->belongsTo(RoomPrices::class);
    }
}
