<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffTCMSUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'csv' => 'required|mimes:csv,xls,xlm,xla,xlc,xlt,xlw',
       ];
    }

    public function messages()
    {
        return [
            'csv' => 'Upload file can only be with this extension :csv,xls,xlm,xla,xlc,xlt,xlw.',
        ];
    }
}
