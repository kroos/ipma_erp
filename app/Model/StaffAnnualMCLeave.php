<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;
// load Model
// use App\Model\Status;



class StaffAnnualMCLeave extends Model
{
	use SoftDeletes;

	protected $table = 'staff_annual_mc_maternity_leaves';

    public function belomgtostaff()
    {
        return $this->belongsTo('App\Model\Staff', 'staff_id');
    }
}
