<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSServiceReportAttendees extends Model
{
	protected $connection = 'mysql';
	protected $table = 'ics_service_report_attendees';

	// public function hasmanyservicereport()
	// {
	// 	return $this->hasMany('App\Model\ICSServiceReport', 'charge_id');
	// }

///////////////////////////////////////////////////////////////////////////////////////////////

	public function belongtoservicereport()
	{
		return $this->belongsTo('App\Model\ICSServiceReport', 'service_report_id');
	}

	public function belongtostaff()
	{
		return $this->belongsTo('App\Model\Staff', 'attended_by');
	}
}
