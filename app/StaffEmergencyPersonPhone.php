<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class StaffEmergencyPersonPhone extends Model
{
    protected $table = 'staff_emergency_person_phone';

    public function belongtoemergencyperson()
    {
    	return $this->belongsTo('App\StaffEmergencyPerson', 'emergency_person_id');
    }
}
