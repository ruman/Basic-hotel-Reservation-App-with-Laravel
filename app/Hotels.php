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

}