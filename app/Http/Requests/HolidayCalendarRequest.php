<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolidayCalendarRequest extends FormRequest
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
            'date_start' => 'required|date_format:Y-m-d',
            'date_end' => 'required|date_format:Y-m-d',
            'holiday' => 'required',
       ];
    }

    public function messages()
    {
        return [
            // 'staff.*.id_card_passport.alpha_num' => 'ID Kad or Passport number can be consists of alphabet and/or digits.',
        ];
    }
}
