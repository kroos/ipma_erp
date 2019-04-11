<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotQuotationSectionItemAttrib extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_quotation_section_item_attributes';

	// public function hasmanyquotsectionitemattrib()
	// {
	// 	return $this->hasMany('App\Model\QuotQuotationSection', 'section_id');
	// }

///////////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoquotsectionitem()
	{
		return $this->belongsTo('\App\Model\QuotQuotationSectionItem', 'item_id');
	}

	public function belongtoquotitemattrib()
	{
		return $this->belongsTo('\App\Model\QuotItemAttribute', 'attribute_id');
	}
}
