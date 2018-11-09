<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffDiscipline extends Model
{
	protected $table = 'staff_disciplines';

	public function belongtostaff()
	{
		return $this->belongsTo('App\Model\Staff');
	}

	public function belongtodiscipline()
	{
		return $this->belongsTo('App\Model\Discipline');
	}
}
