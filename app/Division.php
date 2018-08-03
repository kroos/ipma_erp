<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
	// protected $table = 'divisions';

    hasmanydepartment() {
    	return $this->hasMany('App\Department')
    }
}
