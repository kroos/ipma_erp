<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSServiceReport extends Model
{
	protected $connection = 'mysql';
	protected $table = 'ics_service_reports';

	public function hasmanyattendees()
	{
		return $this->hasMany('App\Model\ICSServiceReportAttendees', 'service_report_id');
	}

	public function hasmanycomplaint()
	{
		return $this->hasMany('App\Model\ICSServiceReportComplaint', 'service_report_id');
	}

	public function hasmanyjob()
	{
		return $this->hasMany('App\Model\ICSServiceReportJob', 'service_report_id');
	}

	public function hasmanymodel()
	{
		return $this->hasMany('App\Model\ICSServiceReportModel', 'service_report_id');
	}

	public function hasmanyserial()
	{
		return $this->hasMany('App\Model\ICSServiceReportSerial', 'service_report_id');
	}

	public function hasmanypart()
	{
		return $this->hasMany('App\Model\ICSServiceReportPart', 'service_report_id');
	}

	public function hasmanylogistic()
	{
		return $this->hasMany('App\Model\ICSServiceReportLogistic', 'service_report_id');
	}

	public function hasmanyadditionalcharge()
	{
		return $this->hasMany('App\Model\ICSServiceReportAdditionalCharge', 'service_report_id');
	}

	public function hasonediscount()
	{
		return $this->hasOne('App\Model\ICSServiceReportDiscount', 'service_report_id');
	}

	public function hasmanyfeedcall()
	{
		return $this->hasMany('App\Model\ICSServiceReportFeedCall', 'service_report_id');
	}

	public function hasmanyfeeditem()
	{
		return $this->hasMany('App\Model\ICSServiceReportFeedItem', 'service_report_id');
	}

	public function hasmanyfeedproblem()
	{
		return $this->hasMany('App\Model\ICSServiceReportFeedProblem', 'service_report_id');
	}

	public function hasmanyfeedrequest()
	{
		return $this->hasMany('App\Model\ICSServiceReportFeedRequest', 'service_report_id');
	}

	public function hasmanyfeedback()
	{
		return $this->hasMany('App\Model\ICSServiceReportFeedback', 'service_report_id');
	}


///////////////////////////////////////////////////////////////////////////////////////////////
	public function belongtostaff()
	{
		return $this->belongsTo('App\Model\Staff', 'staff_id');
	}

	public function belongtoinformby()
	{
		return $this->belongsTo('App\Model\Staff', 'inform_by');
	}

	public function belongtoupdatedby()
	{
		return $this->belongsTo('App\Model\Staff', 'updated_by');
	}

	public function belongtoapprovedby()
	{
		return $this->belongsTo('App\Model\Staff', 'approved_by');
	}

	public function belongtocheckedby()
	{
		return $this->belongsTo('App\Model\Staff', 'checked_by');
	}

	public function belongtosendby()
	{
		return $this->belongsTo('App\Model\Staff', 'send_by');
	}

	public function belongtocustomer()
	{
		return $this->belongsTo('App\Model\Customer', 'customer_id');
	}

	public function belongtocharge()
	{
		return $this->belongsTo('App\Model\ICSCharge', 'charge_id');
	}

	public function belongtoproceed()
	{
		return $this->belongsTo('App\Model\ICSProceed', 'proceed_id');
	}

	public function belongtoinvoice()
	{
		return $this->belongsTo('App\Model\ICSSQLSRVInvoice', 'invoice_id');
	}


}
