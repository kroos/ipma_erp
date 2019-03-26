<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotQuotationExclusion extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_quotation_exclusions';

////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoquot()
	{
		return $this->belongsTo('\App\Model\QuotQuotation', 'quot_id');
	}

	public function belongtoexclusion()
	{
		return $this->belongsTo('\App\Model\QuotExclusion', 'exclusion_id');
	}

}
