<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    protected $table = 'religions';

	public function hasmanystaffprofile()
    {
    	return $this->hasOne('App\Model\StaffProfile');
    }
}
