<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSServiceReportAdditionalCharge extends Model
{
	protected $connection = 'mysql';
	protected $table = 'ics_service_report_additional_charges';

	// public function hasmanyservicereport()
	// {
	// 	return $this->hasMany('App\Model\ICSServiceReport', 'charge_id');
	// }

///////////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoservicereport()
	{
		return $this->belongsTo('App\Model\ICSServiceReport', 'service_report_id');
	}

	public function belongtoamount()
	{
		return $this->belongsTo('App\Model\Amount', 'amount_id');
	}
}
