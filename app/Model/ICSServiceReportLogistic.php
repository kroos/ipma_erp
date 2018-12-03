<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSServiceReportLogistic extends Model
{
	protected $connection = 'mysql';
	protected $table = 'ics_service_report_logistics';

	// public function hasmanyservicereport()
	// {
	// 	return $this->hasMany('App\Model\ICSServiceReport', 'charge_id');
	// }

///////////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoservicereport()
	{
		return $this->belongsTo('App\Model\ICSServiceReport', 'service_report_id');
	}

	public function belongtovehicle()
	{
		return $this->belongsTo('App\Model\Vehicle', 'vehicle_id');
	}
}
