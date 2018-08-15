<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StaffLeave extends Model
{
    protected $table = 'staff_leaves';

    public function hasmanyleaveapproval()
    {
    	return $this->hasMany('App/Model/StaffLeaveApproval', 'staff_leave_id');
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