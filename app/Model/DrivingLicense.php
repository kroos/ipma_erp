<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class DrivingLicense extends Model
{
    protected $table = 'driving_licenses';

    public function hasmanystaffdrivinglicense()
    {
    	return $this->hasMany('App\Model\StaffDrivingLicense', 'driving_license_id');
    }
}
