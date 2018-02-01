<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistration extends FormRequest
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
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users',
            'mobile_number' => 'required|numeric|min:1|unique:users',
            'password'      => 'required|string|min:12|confirmed',
            'password_confirmation' => 'required|same:password'
        ];
    }

    /*=====================================
       Function to display Custom Messages
   ========================================*/
    public function messages() {
        return [
            'first_name.required'			=> 'Please Enter First Name.',
            'last_name.required'			=> 'Please Enter Last Name.',
            'email.required'			    => 'Please Enter Your Email.',
            'mobile_number.required'	    => 'Please Enter Your Mobile number.',
            'password.required'				=> 'Please Enter Password.',
            'password.min'					=> 'Password should be at least 12 characters long.',
            'password_confirmation'			=> 'Please Enter Confirmed Password.',
            'password_confirmation.same'	=> 'New password and confirm password do not match.Please enter both again.',
        ];
    }
}
