<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelImageUploadRequest extends FormRequest
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
            'hotel_id'      => 'bail|required',
            'hotelimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(){
        return [
            'hotelimage.required'=> 'Please Select Image',
            'hotelimage.image' => 'Only Image is Allowed',
            'hotelimage.mimes' => 'Allowed Image Format: jpeg, png, jpg, gif, svg',
        ];
    }
}
