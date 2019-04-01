<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotBank extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_banks';

	public function hasmanyquotbank()
	{
		return $this->hasMany('App\Model\QuotQuotationBank', 'bank_id');
	}
}
