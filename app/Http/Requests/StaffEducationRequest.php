<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffEducationRequest extends FormRequest
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
            'institution' => 'required|string|min:6',
            'from' => 'required|before:to',
            'to' => 'required|after:from',
            'qualification' => 'required|string',
       ];
    }

    public function messages()
    {
        return [
            'from.before' => 'Date From must be before date To.',
            'to.after' => 'Date To must be after than date From.',
        ];
    }
}
