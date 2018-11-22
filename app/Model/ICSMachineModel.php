<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSMachineModel extends Model
{
	protected $connection = 'mysql';
	protected $table = 'ics_machine_models';

	public function hasmanyservicereportmodel()
	{
		return $this->hasMany('App\Model\ICSServiceReportModel', 'model_id');
	}


}
