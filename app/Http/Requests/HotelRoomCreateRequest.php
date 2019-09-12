<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRoomCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hotel_id'=>'required',
            'room_id'  => 'required',
            'price_id'   => 'required',
            'availability' => 'required'
        ];
    }


    public function messages(){
        return [
            'hotel_id.required'=> 'Hotel Is missing. Please Refreash the page.',
            'room_id.required' => 'Please Select Room',
            'price_id.required' => 'Please Select Price',
            'availability.required' => 'Rooms Available is required.',
        ];
    }
}
