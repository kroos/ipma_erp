<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
	protected $table = 'staffs';

	public function hasmanylogin()
	{
		return $this->hasMany('App\Model\Login');
	}

	public function hasmanychildren()
	{
		return $this->hasMany('App\Model\StaffChildren');
	}

	public function hasmanyemergencyperson()
	{
		return $this->hasMany('App\Model\StaffEmergencyPerson');
	}

	public function hasmanysibling()
	{
		return $this->hasMany('App\Model\StaffSibling');
	}

	public function hasmanyspouse()
	{
		return $this->hasMany('App\Model\StaffSpouse');
	}

	public function hasmanydrivinglicense()
	{
		return $this->hasMany('App\Model\StaffDrivingLicense');
	}

	public function hasmanyeducation()
	{
		return $this->hasMany('App\Model\StaffEducation');
	}
}
