<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotQuotationRemark extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_quotation_remarks';

////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoquot()
	{
		return $this->belongsTo('\App\Model\QuotQuotation', 'quot_id');
	}

	public function belongtoremark()
	{
		return $this->belongsTo('\App\Model\QuotRemark', 'remark_id');
	}

}
