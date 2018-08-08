<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffSpouseEditRequest extends FormRequest
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
            'spouse' => 'required|string|min:6',
            'id_card_passport' => 'alpha_num|nullable',
            'phone' => 'required|numeric|min:10',
            'dob' => 'date_format:Y-m-d|nullable',
            'profession' => 'string|nullable',
       ];
    }

    public function messages()
    {
        return [
            'id_card_passport.alpha_num' => 'ID Kad or Passport number can be consists of alphabet and/or digits.',
        ];
    }
}
