<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class StaffEmergencyPerson extends Model
{
    protected $table = 'staff_emergency_person';

    public function hasmanyemergencypersonphone()
    {
    	return $this->hasMany('App\StaffEmergencyPersonPhone');
    }

    public function belongtostaff()
    {
    	return $this->belongsTo('App\Staff', 'staff_id');
    }
}
