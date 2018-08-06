<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
	// protected $table = 'divisions';

    public function hasmanydepartment() {
    	return $this->hasMany('App\Model\Department')
    }
}
