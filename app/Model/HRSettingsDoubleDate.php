<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class HRSettingsDoubleDate extends Model
{
	protected $connection = 'mysql';
	protected $table = 'setting_double_dates';

	// public function hasmanyservicereport()
	// {
	// 	return $this->hasMany('App\Model\HRSettingsDoubleDate', 'status_id');
	// }

///////////////////////////////////////////////////////////////////////////////////////////////
	public function belongtoyesno()
	{
		return $this->belongsTo('\App\Model\YesNoLabel', 'double_date_setting', 'value');
	}

}
