<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class StaffLeave extends Model
{
	use SoftDeletes;

	protected $connection = 'mysql';
	protected $table = 'staff_leaves';
	protected $dates = ['deleted_at'];

	public function hasonestaffleavebackup()
	{
		return $this->hasOne('App\Model\StaffLeaveBackup', 'staff_leave_id');
	}

	public function hasmanystaffapproval()
	{
		return $this->hasMany('App\Model\StaffLeaveApproval', 'staff_leave_id');
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function belongtostaffleavereplacement()
	{
		return $this->belongsTo('App\Model\StaffLeaveReplacement', 'leave_replacement_id');
	}

	public function belongtoleavestatus()
	{
		return $this->belongsTo('App\Model\LeaveStatus', 'active');
	}

	public function belongtostaff()
	{
		return $this->belongsTo('App\Model\Staff', 'staff_id');
	}

	public function belongtoleave()
	{
		return $this->belongsTo('App\Model\Leave', 'leave_id');
	}
}
