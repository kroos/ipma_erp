<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotDealer extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_dealers';

	public function hasmanyquotdealer()
	{
		return $this->hasMany('App\Model\QuotQuotationDealer', 'dealer_id');
	}
}
