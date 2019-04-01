<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotQuotationDealer extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_quotation_dealers';

////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoquot()
	{
		return $this->belongsTo('\App\Model\QuotQuotation', 'quot_id');
	}

	public function belongtodealer()
	{
		return $this->belongsTo('\App\Model\QuotDealer', 'dealer_id');
	}
}
