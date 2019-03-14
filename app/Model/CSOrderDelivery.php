<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class CSOrderDelivery extends Model
{
	protected $connection = 'mysql';
	protected $table = 'cs_order_deliveries';

	public function hasmanyorderitemdelivery()
	{
		return $this->hasMany('App\Model\CSOrderItem', 'delivery_id');
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
