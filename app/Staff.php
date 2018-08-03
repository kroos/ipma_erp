<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
	protected $table = 'staffs';

	public function hasmanylogin()
	{
		return $this->hasMany('App\Login');
	}

	public function hasmanychildren()
	{
		return $this->hasMany('App\StaffChildren');
	}

	public function hasmanyemergencyperson()
	{
		return $this->hasMany('App\StaffEmergencyPerson');
	}

	public function hasmanysibling()
	{
		return $this->hasMany('App\StaffSibling');
	}

	public function FunctionName($value='')
	{
		# code...
	}
}
