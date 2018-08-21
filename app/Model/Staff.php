<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;
// load Model
// use App\Model\Status;


use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
	use SoftDeletes;

	protected $table = 'staffs';
	protected $dates = ['deleted_at'];

	public function hasmanylogin()
	{
		return $this->hasMany('App\Model\Login', 'staff_id');
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

    public function hasmanystaffannualmcleave()
    {
        return $this->hasMany('App\Model\StaffAnnualMCLeave', 'staff_id');
    }

    public function hasmanystaffleave()
    {
        return $this->hasMany('App\Model\StaffLeave', 'staff_id');
    }

    public function hasmanystaffleavereplacement()
    {
        return $this->hasMany('App\Model\StaffLeaveReplacement', 'staff_id');
    }

// https://laravel.com/docs/5.6/eloquent-relationships#many-to-many
    public function belongtomanyposition()
    {
        return $this->belongsToMany('App\Model\Position', 'staff_positions', 'staff_id', 'position_id' )->withPivot('main')->withTimestamps();
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////
    // belongto
    public function belongtogender()
    {
    	return $this->belongsTo('App\Model\Gender', 'gender_id');
    }

    public function belongtocountry()
    {
    	return $this->belongsTo('App\Model\Country', 'country_id');
    }

    public function belongtoreligion()
    {
    	return $this->belongsTo('App\Model\Religion', 'religion_id');
    }

    public function belongtorace()
    {
    	return $this->belongsTo('App\Model\Race', 'race_id');
    }

    public function belongtostatus()
    {
    	return $this->belongsTo('App\Model\Status', 'status_id');
    }

    public function belongtomaritalstatus()
    {
    	return $this->belongsTo('App\Model\MaritalStatus', 'marital_status_id');
    }

    public function belongtolocation()
    {
    	return $this->belongsTo('App\Model\Location', 'location_id');
    }

}
