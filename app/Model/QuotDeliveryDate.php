<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotDeliveryDate extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_delivery_dates';

	public function hasmanyquot()
	{
		return $this->hasMany('App\Model\QuotQuotation', 'attrib_id');
	}
}
