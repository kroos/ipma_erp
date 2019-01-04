<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ToDoSchedule extends Model
{
	protected $connection = 'mysql';
	protected $table = 'todo_schedules';

	public function hasmanytasker()
	{
		return $this->hasMany('App\Model\ToDoStaff', 'schedule_id');
	}

	public function hasmanytask()	// hasonetask
	{
		return $this->hasMany('App\Model\ToDoList', 'schedule_id');
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function belongtocreator()
	{
		return $this->belongsTo('App\Model\Staff', 'created_by');
	}

	public function belongtocategory()
	{
		return $this->belongsTo('App\Model\ToDoCategory', 'category_id');
	}

	public function belongtopriority()
	{
		return $this->belongsTo('App\Model\ToDoPriority', 'priority_id');
	}
}