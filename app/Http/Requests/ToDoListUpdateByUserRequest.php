<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToDoListUpdateByUserRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			// 'completed' => 'required',
			'description' => 'required',
		];
	}
	
	public function messages()
	{
		return [
			'description' => 'Please insert the remarks of the task. ',
		];
	}
}
