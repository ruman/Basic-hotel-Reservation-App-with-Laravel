<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomImageUploadRequest extends FormRequest
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
            'room_id'      => 'bail|required',
            'room_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(){
        return [
            'room_image.required'=> 'Please Select Image',
            'room_image.image' => 'Only Image is Allowed',
            'room_image.mimes' => 'Allowed Image Format: jpeg, png, jpg, gif, svg',
        ];
    }
}
