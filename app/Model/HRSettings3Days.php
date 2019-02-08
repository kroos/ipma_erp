<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class HRSettings3Days extends Model
{
	protected $connection = 'mysql';
	protected $table = 'setting_3_days_checkings';

	// public function hasmanyservicereport()
	// {
	// 	return $this->hasMany('App\Model\HRSettingsDoubleDate', 'status_id');
	// }

///////////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoyesno()
	{
		return $this->belongsTo('\App\Model\YesNoLabel', 't3_days_checking', 'value');
	}

}
