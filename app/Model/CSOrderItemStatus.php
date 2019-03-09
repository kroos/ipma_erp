<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class CSOrderItemStatus extends Model
{
	protected $connection = 'mysql';
	protected $table = 'cs_order_item_statuses';

	public function hasmanyorderitemstatus()
	{
		return $this->hasMany('App\Model\CSOrderItem', 'order_item_status_id');
	}

/////////////////////////////////////////////////////////////////////////////////////

	// public function belongtoorder()
	// {
	// 	return $this->belongsTo('\App\Model\CSOrder', 'order_id');
	// }

	// public function belongtoorderstatus()
	// {
	// 	return $this->belongsTo('\App\Model\CSOrderItemStatus', 'order_item_status_id');
	// }


}
