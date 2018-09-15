<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class LeaveStatus extends Model
{
    protected $table = 'leave_statuses';

    public function hasmanystaffleave()
    {
    	return $this->belongsTo('App\Model\StaffLeave', 'active');
    }

}
