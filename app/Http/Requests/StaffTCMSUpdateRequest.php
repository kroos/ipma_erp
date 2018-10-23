<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffTCMSUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'csv' => 'required|',
       ];
    }

    public function messages()
    {
        return [
            'staff.*.id_card_passport.alpha_num' => 'ID Kad or Passport number can be consists of alphabet and/or digits.',
        ];
    }
}
