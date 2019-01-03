<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ToDoPriority extends Model
{
	protected $connection = 'mysql';
	protected $table = 'todo_priorities';

	public function hasmanyschedule()
	{
		$this->hasMany('App\Model\ToDoSchedule', 'priority_id');
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// public function belongtoschedule()
	// {
	// 	return $this->belongsTo('App\Model\ToDoSchedule', 'schedule_id');
	// }
}