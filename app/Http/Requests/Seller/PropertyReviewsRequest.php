<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class PropertyReviewsRequest extends FormRequest
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
            'rating'	=> 'required',
            'reason_for_rating' => 'required',
            'comments' => 'required|max:150',
        ];
    }

    /*=====================================
		Function to display Custom Messages
    ========================================*/
    public function messages() {
        return [
            'rating.required'				=> 'Please Enter rating.',
            'reason_for_rating.required'    => 'Please select reason.',
            'comments.required'				=> 'Please enter reviews.',
            'comments.max'                  => 'Comment can not be more than 150 character long.',
        ];
    }
}
