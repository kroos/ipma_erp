<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ToDoCategory extends Model
{
	protected $connection = 'mysql';
	protected $table = 'todo_categories';

	public function hasmanyschedule()
	{
		$this->hasMany('App\Model\ToDoSchedule', 'category_id');
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// public function belongtoleavestatus()
	// {
		// return $this->belongsTo('App\Model\LeaveStatus', 'active');
	// }
}