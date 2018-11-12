<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffEmergencyPerson extends Model
{
	protected $connection = 'mysql';
    protected $table = 'staff_emergency_person';

    public function hasmanyemergencypersonphone()
    {
    	return $this->hasMany('App\Model\StaffEmergencyPersonPhone', 'emergency_person_id');
    }

    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff', 'staff_id');
    }
}
