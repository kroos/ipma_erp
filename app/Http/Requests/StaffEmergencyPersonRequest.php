<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffEmergencyPersonRequest extends FormRequest
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
        // dd($this->staffEmergencyPerson['id']);
        return [
            'contact_person' => 'required|string|min:6',
            'relationship' => 'required|string',
            'address' => 'nullable|string',
            'emerg.*.phone' => 'required|numeric|unique:staff_emergency_person_phone,phone,'.$this->staffEmergencyPerson['id'],
       ];
    }

    public function messages()
    {
        return [
            'emerg.*.phone.unique' => 'The phone number has already been taken.',
        ];
    }
}
