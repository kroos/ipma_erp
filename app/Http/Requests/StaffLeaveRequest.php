<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffLeaveRequest extends FormRequest
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
            // compulsory
            'leave_id' => 'required|integer',
            'reason' => 'string',
            'akuan' => 'required',

            // sometimes it needs..
            
       ];
    }

    // public function messages()
    // {
    //     return [
    //         'staff.*.id_card_passport.alpha_num' => 'ID Kad or Passport number can be consists of alphabet and/or digits.',
    //     ];
    // }
}
