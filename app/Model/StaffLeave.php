<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class StaffLeave extends Model
{
    use SoftDeletes;

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

    public function hasmanystaffleavereplacement()
    {
        return $this->hasMany('App\Model\StaffLeaveReplacement', 'staff_leave_id');
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff', 'staff_id');
    }

    public function belongtoleave()
    {
    	return $this->belongsTo('App\Model\Leave', 'leave_id');
    }
}
