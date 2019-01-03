<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ToDoStaff extends Model
{
	protected $connection = 'mysql';
	protected $table = 'todo_staffs';

	// public function hasmanytasker()
	// {
	// 	$this->hasMany('App\Model\ToDoStaff', 'staff_id');
	// }

	// public function hasmanytask()
	// {
	// 	$this->hasMany('App\Model\ToDoList', 'schedule_id');
	// }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function belongtoschedule()
	{
		return $this->belongsTo('App\Model\ToDoSchedule', 'schedule_id');
	}

	public function belongtostaff()
	{
		return $this->belongsTo('App\Model\Staff', 'staff_id');
	}
}