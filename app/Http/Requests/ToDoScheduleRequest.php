<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToDoScheduleRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			'category_id' => 'required',
			'td.*.staff_id' => 'required',
			'task' => 'required',
			'description' => 'required',
			'dateline' => 'required|date_format:Y-m-d',
			'period_reminder' => 'required|integer',
			'priority_id' => 'required',
		];
	}
	
	public function messages()
	{
		return [
			'category_id' => 'Please choose. ',
			'td.*.staff_id' => 'Please select assignee. ',
			'task' => 'Please insert task. ',
			'description' => 'Please insert the description of the task. ',
			'dateline' => 'Please set the dateline. ',
			'period_reminder' => 'Please insert the days before the dateline kick-in. ',
			'priority_id' => 'Please choose the priority of this task. ',
		];
	}
}
