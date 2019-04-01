<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotQuotationBank extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_quotation_banks';

////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoquot()
	{
		return $this->belongsTo('\App\Model\QuotQuotation', 'quot_id');
	}

	public function belongtobank()
	{
		return $this->belongsTo('\App\Model\QuotBank', 'bank_id');
	}
}
