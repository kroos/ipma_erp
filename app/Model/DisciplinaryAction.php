<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class DisciplinaryAction extends Model
{
	protected $connection = 'mysql';
	protected $table = 'disciplinary_actions';

	public function hasmanystaffdisciplinaryaction()
	{
		return $this->hasMany('\App\Model\StaffDisciplinaryAction', 'disciplinary_action');
	}

	// public function belongtostaff()
	// {
	// 	return $this->belongsTo('App\Model\Staff', 'staff_id');
	// }
}
