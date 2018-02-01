<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class EditProfile extends FormRequest
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
            'first_name'	=> array( 'required', 'max:30'  ),
            //'last_name'		=> array( 'required','alpha_num', 'max:30'  ),
            'last_name'		=> array( 'required', 'max:30'  ),
            'mobile_number' => 'required|numeric',
            'pic'			=> 'max:1024|mimes:jpeg,jpg,png',
        ];
    }

    public function messages() {
        return [
            'first_name.required'	=> 'First Name can not be left empty.',
            'first_name.max'		=> 'Name can not exceed more than 30 character ',
            'first_name.alpha_num'	=> 'Please enter only numbers and alphabets',
            'last_name.required'	=> 'Last Name can not be left empty.',
            'last_name.max'			=> 'Name can not exceed more than 30 character ',
            'last_name.alpha_num'	=> 'Please enter only numbers and alphabets',
            'pic.mimes'             => 'Invalid file extension.',
            'pic.max'				=> 'Image size can not be greater than 1 mb.'
        ];
    }
}
