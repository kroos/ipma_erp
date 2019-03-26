<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotQuotationTermOfPayment extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_quotation_term_of_payments';

	// public function hasmanyquotsectionitem()
	// {
	// 	return $this->hasMany('App\Model\QuotQuotationSectionItem', 'section_id');
	// }

////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoquot()
	{
		return $this->belongsTo('\App\Model\QuotQuotation', 'quot_id');
	}
}
