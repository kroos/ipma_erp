<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
	protected $connection = 'mysql';
	protected $table = 'taxes';
	
	public function hasmanyquotsectionitemtax()
	{
		return $this->hasMany('App\Model\QuotQuotationSectionItem', 'tax_id');
	}

	public function hasmanyquot()
	{
		return $this->hasMany('\App\Model\QuotQuotation', 'tax_id');
	}

}
