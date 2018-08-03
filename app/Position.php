<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    // protected $table = 'positions';

    public function belongtodivision()
    {
    	return $this->belongsTo('App\Division', 'division_id');
    }

    public function belongtodepartment()
    {
    	return $this->belongsTo('App\Department', 'department_id');
    }
}
