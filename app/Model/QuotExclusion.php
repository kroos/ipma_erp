<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotExclusion extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_exclusions';

	public function hasmanyquotexclusion()
	{
		return $this->hasMany('App\Model\QuotQuotationExclusion', 'exclusion_id');
	}
}
