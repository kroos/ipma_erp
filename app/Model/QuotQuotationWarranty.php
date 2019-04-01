<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotQuotationWarranty extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_quotation_warranties';

////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoquot()
	{
		return $this->belongsTo('\App\Model\QuotQuotation', 'quot_id');
	}

	public function belongtowarranty()
	{
		return $this->belongsTo('\App\Model\QuotWarranty', 'warranty_id');
	}
}
