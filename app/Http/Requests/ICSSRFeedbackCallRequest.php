<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ICSSRFeedbackCallRequest extends FormRequest
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
            'date' => 'required|date_format:"Y-m-d"|',
            'pic' => 'required',
            'remarks' => 'required',

            // sometimes it needs..
            // 'staff_leave_replacement_id' => 'sometimes|required|integer',
       ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Please insert the date of call.',
            'date.date_format' => 'Please insert date in this format (YYYY-MM-DD). Example: '.date('Y-m-d').'. ',
            'pic.required' => 'Please insert customer person in charge. ',
            'remarks.required' => 'Please summarize your conversation in "Remarks" field. ',
        ];
    }
}
