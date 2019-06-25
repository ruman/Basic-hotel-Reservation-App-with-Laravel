<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;

class ReactController extends Controller
{
    //
    public function show(){
    	$countries = Countries::all()->pluck('name.common', 'postal')->toJson();
    	return view('welcome')->with(compact('countries'));
    }
}
