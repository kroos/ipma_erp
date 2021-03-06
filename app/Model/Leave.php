<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
	protected $connection = 'mysql';
	protected $table = 'leaves';

	public function hasmanystaffleave()
	{
		return $this->hasMany('App\Model\StaffLeave', 'leave_id');
	}
}
