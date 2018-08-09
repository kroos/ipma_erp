<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffChildrenRequest extends FormRequest
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
            'children' => 'required|string|min:6',
            'dob' => 'date_format:Y-m-d|nullable',
            'gender_id' => 'required|numeric',
            'education_level_id' => 'required|numeric',
            'health_status_id' => 'required|numeric',
            'tax_exemption' => 'nullable',
            'tax_exemption_percentage_id' => 'required_if:tax_exemption,1',
       ];
    }

    public function messages()
    {
        return [
            'phone.numeric' => 'Phone number must be numeric.',
        ];
    }
}
