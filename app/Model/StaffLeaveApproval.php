<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StaffLeaveApproval extends Model
{
    protected $table = 'staff_leave_approvals';

    public function belongtostaffleave()
    {
    	return $this->belongsTo('App\Model\StaffLeave', 'staff_leave_id');
    }

    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff', 'staff_id');
    }
}
