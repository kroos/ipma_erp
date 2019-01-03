<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ToDoList extends Model
{
	protected $connection = 'mysql';
	protected $table = 'todo_list';

	// public function hasmanyschedule()
	// {
	// 	$this->hasMany('App\Model\ToDoSchedule', 'category_id');
	// }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function belongtoschedule()
	{
		return $this->belongsTo('App\Model\ToDoSchedule', 'schedule_id');
	}
}