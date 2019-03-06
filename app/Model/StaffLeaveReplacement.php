<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffLeaveReplacement extends Model
{
	protected $connection = 'mysql';
	protected $table = 'staff_leave_replacements';

	public function hasmanystaffleave()
	{
		return $this->belongsTo('App\Model\StaffLeave', 'leave_replacement_id');
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function belongtostaff()
	{
		return $this->belongsTo('App\Model\Staff', 'staff_id');
	}
}
