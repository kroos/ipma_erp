<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotItem extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_items';

	public function hasmanyquotsectionitem()
	{
		return $this->hasMany('App\Model\QuotQuotationSectionItem', 'item_id');
	}
}
