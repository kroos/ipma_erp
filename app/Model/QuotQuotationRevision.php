<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotQuotationRevision extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_quotation_revisions';

////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoquot()
	{
		return $this->belongsTo('\App\Model\QuotQuotation', 'quot_id');
	}


}
