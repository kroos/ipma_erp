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
        // dd($this->staff['id']);
        return [
            'image' => 'file|image|max:5000',
            'id_card_passport' => 'required|integer',
            'email' => 'required|email|unique:staffs,email,'.$this->staff['id'],
            'drivelicense.*' => 'nullable'
            'religion_id' => 'required|integer',
            'gender_id' => 'required|integer',
            'race_id' => 'required|integer',
            'address' => 'required',
            'pob' => 'nullable',
            'country_id' => 'required|integer',
            'marital_status_id' => 'required|integer',
            'mobile' => 'required|numeric|unique:staffs,mobile,'.$this->staff['id'],
            'phone' => 'nullable|numeric',
            'dob' => 'required|date_format:Y-m-d',
            'cimb_account' => 'required|digits:10||unique:staffs,cimb_account,'.$this->staff['id'],
            'epf_no' => 'nullable|alpha_num||unique:staffs,epf_no,'.$this->staff['id'],
            'income_tax_no' => 'nullable||unique:staffs,income_tax_no,'.$this->staff['id'],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Email has been taken. Please choose another.',
            'mobile.unique' => 'Mobile phone number has been taken. Please choose another.',
            'cimb_account.unique' => 'CIMB account has been taken. Please choose another.',
            'epf_no.unique' => 'EPF has been taken. Please choose another.',
            'income_tax_no.unique' => 'Income Tax Account has been taken. Please choose another.',
        ];
    }
}
