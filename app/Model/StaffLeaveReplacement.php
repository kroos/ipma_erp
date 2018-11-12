<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffLeaveReplacement extends Model
{
	protected $connection = 'mysql';
    protected $table = 'staff_leave_replacements';


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function belongtostaffleave()
    {
    	return $this->belongsTo('App\Model\StaffLeave', 'staff_leave_id');
    }
    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff', 'staff_id');
    }
}
