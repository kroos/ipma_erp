<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotUOM extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_uom';

	public function hasmanyquotsectionitemuom()
	{
		return $this->hasMany('App\Model\QuotQuotationSectionItem', 'uom_id');
	}
}
