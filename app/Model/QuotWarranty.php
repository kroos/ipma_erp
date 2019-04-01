<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotWarranty extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_warranties';

	public function hasmanyquotwaaranty()
	{
		return $this->hasMany('App\Model\QuotQuotationWarranty', 'warranty_id');
	}
}
