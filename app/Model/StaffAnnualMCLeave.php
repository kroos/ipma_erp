<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;
// load Model
// use App\Model\Status;

use Illuminate\Database\Eloquent\SoftDeletes;

class StaffAnnualMCLeave extends Model
{
	use SoftDeletes;

	protected $connection = 'mysql';
	protected $table = 'staff_annual_mc_maternity_leaves';


	// SALAH EJA PULOK DOHHHHHH
    public function belomgtostaff()
    {
        return $this->belongsTo('App\Model\Staff', 'staff_id');
    }
}
