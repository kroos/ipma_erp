<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    // protected $table = 'positions';

    public function belongtodivision()
    {
    	return $this->belongsTo('App\Model\Division', 'division_id');
    }

    public function belongtodepartment()
    {
    	return $this->belongsTo('App\Model\Department', 'department_id');
    }
}
