<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffSiblingEditRequest extends FormRequest
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
            'sibling' => 'required|string|min:6',
            'phone' => 'required|numeric|min:10',
            'dob' => 'date_format:Y-m-d|nullable',
            'profession' => 'string|nullable',
       ];
    }

    public function messages()
    {
        return [
            'phone.numeric' => 'Phone number must be numeric.',
        ];
    }
}
