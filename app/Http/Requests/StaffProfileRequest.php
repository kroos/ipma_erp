<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffProfileRequest extends FormRequest
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
        // dd($this->user['id']);
        return [
            'image' => 'file|image|max:5000',
            'id_card_passport' => 'required|integer',
            'religion_id' => 'required|integer',
            'gender_id' => 'required|integer',
            'race_id' => 'required|integer',
            'address' => 'required',
            'pob' => 'nullable',
            'country_id' => 'required|integer',
            'marital_status_id' => 'required|integer',
            'mobile' => 'required|numeric',
            'phone' => 'nullable|numeric',
            'dob' => 'required|date_format:Y-m-d',
            'cimb_account' => 'required|digits:10',
            'epf_no' => 'nullable|alpha_num',
            'income_tax_no' => 'nullable',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
