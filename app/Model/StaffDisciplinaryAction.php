<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffDisciplinaryAction extends Model
{
	protected $connection = 'mysql';
	protected $table = 'staff_disciplinary_actions';

	public function belongtostaff()
	{
		return $this->belongsTo('App\Model\Staff', 'staff_id');
	}

	public function belongtodisciplinaryaction()
	{
		return $this->belongsTo('App\Model\DisciplinaryAction', 'disciplinary_action');
	}
}
