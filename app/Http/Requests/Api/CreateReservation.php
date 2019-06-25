<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateReservation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hotel_id'  => 'required',
            'room_id'   => 'required',
            'check_in'  => 'required',
            'check_out'  => 'required',
            'first_name'  => 'required',
            'last_name'  => 'required',
            'address'  => 'required',
            'city'  => 'required',
            'country'  => 'required',
            'phone'  => 'required',
            'email'  => 'required|email'
        ];
    }

    public function messages(){
        return [
            'hotel_id.required'=> 'Hotel Info missing. Please Refresh the page and try again',
            'room_id.required'=> 'Room Info missing. Please Refresh the page and try again',
            'check_in.required'=> 'Check In Date Required',
            'check_out.required'=> 'Check out Date Required',
            'first_name.required'=> 'Please Enter First Name',
            'last_name.required'=> 'Please Enter Last Name',
            'address.required'=> 'Please Enter Address',
            'city.required'=> 'Please Enter City',
            'country.required'=> 'Please Enter Country',
            'phone.required'=> 'Please Enter Phone',
            'email.required'=> 'Please Enter Email',
            'email.email'=> 'Please Enter valid Email address',
        ];
    }
}
