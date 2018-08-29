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
            'staff_leave_replacement_id' => 'sometimes|required|integer',
       ];
    }

    public function messages()
    {
        return [
            'leave_id.required' => 'Please choose your leave type',
            'akuan.required' => 'Please tick as your acknowledgement',
            'staff_leave_replacement_id.required' => 'Please select your replacement leave',
        ];
    }
}
