<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSCategory extends Model
{
	protected $connection = 'mysql';
	protected $table = 'ics_categories';

	public function hasmanyservicereport()
	{
		return $this->hasMany('App\Model\ICSServiceReport', 'category_id');
	}

///////////////////////////////////////////////////////////////////////////////////////////////

}
