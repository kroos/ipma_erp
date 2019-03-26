<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotRemark extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_remarks';

	public function hasmanyquotquotationremarks()
	{
		return $this->hasMany('App\Model\QuotQuotationRemark', 'remark_id');
	}
}
