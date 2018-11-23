<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSServiceReportJob extends Model
{
	protected $connection = 'mysql';
	protected $table = 'ics_service_report_jobs';

	public function hasmanysrjobdetail()
	{
		return $this->hasMany('App\Model\ICSServiceReportJobDetail', 'service_report_job_id');
	}

	public function hasonesrjobworkingtime()
	{
		return $this->hasMany('App\Model\ICSServiceReportJobDetail', 'service_report_job_id');
	}

///////////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoservicereport()
	{
		return $this->belongsTo('App\Model\ICSServiceReport', 'service_report_id');
	}
}