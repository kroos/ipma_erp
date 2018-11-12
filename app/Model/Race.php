<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
	protected $connection = 'mysql';
    protected $table = 'races';

    public function hasmanystaffprofile()
    {
    	return $this->hasOne('App\Model\StaffProfile');
    }
}
