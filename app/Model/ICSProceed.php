<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSProceed extends Model
{
	protected $connection = 'mysql';
	protected $table = 'ics_charges';

	public function hasoneservicereport()
	{
		return $this->hasOne('App\Model\ICSServiceReport', 'proceed_id');
	}
}
