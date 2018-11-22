<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSServiceReportJobDetail extends Model
{
	protected $connection = 'mysql';
	protected $table = 'ics_sr_job_details';

	// public function hasmanyservicereport()
	// {
	// 	return $this->hasMany('App\Model\ICSServiceReport', 'charge_id');
	// }

///////////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoservicereportjob()
	{
		return $this->belongsTo('App\Model\ICSServiceReportJob', 'service_report_job_id');
	}
}
