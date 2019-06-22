<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    //
    public function hotels(){
    	return $this->belongsToMany(Hotels::class);
    }

    public function rooms(){
    	return $this->hasMany(Rooms::class);
    }
}
