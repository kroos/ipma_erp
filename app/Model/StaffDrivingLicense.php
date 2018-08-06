<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffDrivingLicense extends Model
{
    protected $table = 'staffs_driving_licenses';

    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff', 'staff_id');
    }

    public function belongtodrivinglicense()
    {
    	return $this->belongsTo('App\Model\DrivingLicense', 'driving_license_id');
    }
}
