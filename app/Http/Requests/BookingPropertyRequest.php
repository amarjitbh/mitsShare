<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingPropertyRequest extends FormRequest
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
            'total_amount'  => 'required|numeric',
            'start_date'	=> 'required|',
            'end_date'      => 'required|after_or_equal:start_date',
        ];
    }

    /*=====================================
		Function to display Custom Messages
    ========================================*/
    public function messages() {
        return [
            'start_date.required'   => 'Please Enter Start Date.',
            'end_date.required'     => 'Please Enter End Date.',
            'end_date.after'        => 'End Date must be greater than Start Date.'
        ];
    }
}
