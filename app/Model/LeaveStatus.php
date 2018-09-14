<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class LeaveStatus extends Model
{
    protected $table = 'leave_statuses';

    public function hasonestaffleave()
    {
    	return $this->belongsTo('App\Model\StaffLeave');
    }

}
