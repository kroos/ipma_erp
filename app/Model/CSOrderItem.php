<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class CSOrderItem extends Model
{
	protected $connection = 'mysql';
	protected $table = 'cs_order_items';

	// public function hasmanyorderitem()
	// {
	// 	return $this->hasMany('App\Model\CSOrderItem', 'order_id');
	// }

/////////////////////////////////////////////////////////////////////////////////////

	public function belongtoorder()
	{
		return $this->belongsTo('\App\Model\CSOrder', 'order_id');
	}

	public function belongtoorderstatus()
	{
		return $this->belongsTo('\App\Model\CSOrderItemStatus', 'order_item_status_id');
	}

	public function belongtoorderdelivery()
	{
		return $this->belongsTo('\App\Model\CSOrderDelivery', 'delivery_id');
	}
}
