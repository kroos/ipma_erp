<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffSpouseRequest extends FormRequest
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
            'staff.*.spouse' => 'required|string|min:6',
            'staff.*.id_card_passport' => 'alpha_num|nullable',
            'staff.*.phone' => 'required|numeric|min:10',
            'staff.*.dob' => 'date_format:Y-m-d|nullable',
            'staff.*.profession' => 'string|nullable',
       ];
    }

    public function messages()
    {
        return [
            'staff.*.id_card_passport.alpha_num' => 'ID Kad or Passport number can be consists of alphabet and/or digits.',
        ];
    }
}
