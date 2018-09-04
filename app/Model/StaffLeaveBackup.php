<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffLeaveBackup extends Model
{
    protected $table = 'staff_leave_backups';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff', 'staff_id');
    }

    public function belongtostaffleave()
    {
    	return $this->belongsTo('App\Model\StaffLeave', 'staff_leave_id');
    }
}
