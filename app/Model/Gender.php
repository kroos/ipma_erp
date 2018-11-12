<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
	protected $connection = 'mysql';
    protected $table = 'genders';

    public function hasonestaffprofile()
    {
    	return $this->hasOne('App\Model\StaffProfile');
    }

    public function hasonestaffchildren()
    {
    	return $this->hasOne('App\Model\StaffChildren');
    }

}
