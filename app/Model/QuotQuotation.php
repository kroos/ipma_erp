<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotQuotation extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_quotations';

	public function hasmanyquotsection()
	{
		return $this->hasMany('App\Model\QuotQuotationSection', 'quot_id');
	}

	public function hasmanytermofpayment()
	{
		return $this->hasMany('\App\Model\QuotQuotationTermOfPayment', 'quot_id');
	}

	public function hasmanyexclusions()
	{
		return $this->hasMany('\App\Model\QuotQuotationExclusion', 'quot_id');
	}

	public function hasmanyremarks()
	{
		return $this->hasMany('\App\Model\QuotQuotationRemark', 'quot_id');
	}

///////////////////////////////////////////////////////////////////////////////
	public function belongtostaff()
	{
		return $this->belongsTo('\App\Model\Staff', 'staff_id');
	}

	public function belongtocustomer()
	{
		return $this->belongsTo('\App\Model\Customer', 'customer_id');
	}

	public function belongtocurrency()
	{
		return $this->belongsTo('\App\Model\Currency', 'currency_id');
	}
}