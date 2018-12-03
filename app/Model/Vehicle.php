<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
	protected $connection = 'mysql';
	protected $table = 'vehicles';

	public function hasmanysrlogistic()
	{
		return $this->hasMany('App\Model\ICSServiceReportLogistic', 'vehicle_id');
	}

	public function belongtovehiclecategory()
	{
		return $this->belongsTo('\App\Model\VehicleCategory', 'vehicle_category_id');
	}
}
