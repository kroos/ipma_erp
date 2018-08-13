<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';

    public function hasonestaff()
    {
    	return $this->hasOne('App\Model\Staff', 'position_id');
    }

    public function hasonecategoryposition()
    {
    	return $this->hasOne('App\Model\CategoryPosition', 'position_id');
    }

    public function belongtodivision()
    {
    	return $this->belongsTo('App\Model\Division', 'division_id');
    }

    public function belongtodepartment()
    {
    	return $this->belongsTo('App\Model\Department', 'department_id');
    }
}
