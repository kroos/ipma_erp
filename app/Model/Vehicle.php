<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
	protected $connection = 'mysql';
	protected $table = 'vehicles';

	public function hasmanyservicereport()
	{
		return $this->hasMany('App\Model\ICSServiceReport');
	}
}
