<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotItemAttribute extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_item_attributes';

	public function hasmanyquotsectionitemattrib()
	{
		return $this->hasMany('App\Model\QuotQuotationSectionItemAttrib', 'attribute_id');
	}
}
