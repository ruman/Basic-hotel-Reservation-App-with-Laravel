<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\User;
use Illuminate\Support\Facades\Auth;
// use Validator;

class AuthController extends Controller
{
	public $successStatus = 200;

    public function login(){
    	// dd($request->input('password'));
    	if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
			$user = Auth::user(); 
			$success['token'] =  $user->createToken('AppName')-> accessToken; 
			return response()->json(['success' => $success], $this-> successStatus); 
		} else{ 
			return response()->json(['error'=>'Unauthorised'], 401); 
		} 
    }

    public function getUser(){
    	$user = Auth::user();
		return response()->json(['success' => $user], $this->successStatus);  
    }
}
