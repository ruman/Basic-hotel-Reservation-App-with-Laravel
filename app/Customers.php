<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    public $fillable = [
    	'first_name',
    	'last_name',
    	'address',
    	'city',
    	'country',
    	'phone',
    	'fax',
    	'email',
    ];
}
