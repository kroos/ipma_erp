<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class CSOrder extends Model
{
	protected $connection = 'mysql';
	protected $table = 'cs_orders';

	public function hasmanyorderitem()
	{
		return $this->hasMany('App\Model\CSOrderItem', 'order_id');
	}

/////////////////////////////////////////////////////////////////////////////////////

	public function belongtocustomer()
	{
		return $this->belongsTo('\App\Model\Customer', 'customer_id');
	}

	public function belongtoinformerorder()
	{
		return $this->belongsTo('\App\Model\Staff', 'informed_by');
	}

	public function belongtopic()
	{
		return $this->belongsTo('\App\Model\Staff', 'pic');
	}

}
