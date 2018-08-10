<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffEmergencyPersonPhoneRequest extends FormRequest
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
        // dd($this->staffEmergencyPersonPhone['id']);
        return [
            'phone' => 'required|numeric|unique:staff_emergency_person_phone,phone,'.$this->staffEmergencyPersonPhone['id'],
       ];
    }

    public function messages()
    {
        return [
            'phone.unique' => 'The phone number has already been taken.',
        ];
    }
}
