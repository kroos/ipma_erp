<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSStatus extends Model
{
	protected $connection = 'mysql';
	protected $table = 'ics_status';

	public function hasmanyservicereport()
	{
		return $this->hasMany('App\Model\ICSServiceReport', 'status_id');
	}

///////////////////////////////////////////////////////////////////////////////////////////////

}
