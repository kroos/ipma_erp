<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class QuotQuotationSectionItem extends Model
{
	protected $connection = 'mysql';
	protected $table = 'quot_quotation_section_items';

	public function hasmanyquotsectionitemattrib()
	{
		return $this->hasMany('App\Model\QuotQuotationSectionItemAttrib', 'item_id');
	}

//////////////////////////////////////////////////////////////////////////////////////
	public function belongtoquotsection()
	{
		return $this->belongsTo('\App\Model\QuotQuotationSection', 'section_id');
	}

	public function belongtoquotitem()
	{
		return $this->belongsTo('\App\Model\QuotItem', 'item_id');
	}

	public function belongtoquotuom()
	{
		return $this->belongsTo('\App\Model\QuotUOM', 'uom_id');
	}

	public function belongtotax()
	{
		return $this->belongsTo('\App\Model\Tax', 'tax_id');
	}
}
