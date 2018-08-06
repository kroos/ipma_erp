<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffEmergencyPerson extends Model
{
    protected $table = 'staff_emergency_person';

    public function hasmanyemergencypersonphone()
    {
    	return $this->hasMany('App\Model\StaffEmergencyPersonPhone');
    }

    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff', 'staff_id');
    }
}
