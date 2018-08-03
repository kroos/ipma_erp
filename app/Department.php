<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // protected $table = 'departments';

    belongtodivision() {
    	return $this->belongsTo('App\Division', 'division_id');
    }
}
