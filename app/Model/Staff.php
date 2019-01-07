<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;
// load Model
// use App\Model\Status;


use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
	use SoftDeletes;

    protected $connection = 'mysql';
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

    public function hasmanystaffposition()
    {
        return $this->hasMany('\App\Model\StaffPosition', 'staff_id');
    }

    public function hasmanystaffleavebackup()
    {
        return $this->hasMany('\App\Model\StaffLeaveBackup', 'staff_id');
    }

    public function hasmanystaffleaveapproval()
    {
        return $this->hasMany('\App\Model\StaffLeaveApproval', 'staff_id');
    }

    public function hasmanystafftcms()
    {
        return $this->hasMany('\App\Model\StaffTCMS', 'staff_id');
    }

// service report
    public function hasmanyservicereport()
    {
        return $this->hasMany('\App\Model\ICSServiceReport', 'staff_id');
    }

    public function hasmanysrinformer()
    {
        return $this->hasMany('\App\Model\ICSServiceReport', 'inform_by');
    }

    public function hasmanysrchecker()
    {
        return $this->hasMany('\App\Model\ICSServiceReport', 'checked_by');
    }

    public function hasmanysrsender()
    {
        return $this->hasMany('\App\Model\ICSServiceReport', 'send_by');
    }

    public function hasmanysrupdater()
    {
        return $this->hasMany('\App\Model\ICSServiceReport', 'updated_by');
    }

    public function hasmanysrapproval()
    {
        return $this->hasMany('\App\Model\ICSServiceReport', 'approved_by');
    }

    public function hasmanysrattendees()
    {
        return $this->hasMany('\App\Model\ICSServiceReportAttendees', 'attended_by');
    }

// todo list
    public function hasmanytasker()
    {
        return $this->hasMany('\App\Model\ToDoStaff', 'staff_id');
    }

    public function hasmanytaskcreator()
    {
        return $this->hasMany('\App\Model\ToDoSchedule', 'created_by');
    }

    public function hasmanydoers()
    {
        return $this->hasMany('\App\Model\ToDoList', 'updated_by');
    }
// https://laravel.com/docs/5.6/eloquent-relationships#many-to-many
    public function belongtomanyposition()
    {
        return $this->belongsToMany('App\Model\Position', 'staff_positions', 'staff_id', 'position_id' )->withPivot('main')->withPivot('id')->withTimestamps();
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
