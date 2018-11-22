<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSCharge extends Model
{
	protected $connection = 'mysql';
	protected $table = 'ics_charges';

	public function hasmanyservicereport()
	{
		return $this->hasMany('App\Model\ICSServiceReport', 'charge_id');
	}
}
