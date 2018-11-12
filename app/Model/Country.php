<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	protected $connection = 'mysql';
    protected $table = 'countries';

    public function hasmanystaffprofile()
    {
    	return $this->hasOne('App\Model\StaffProfile');
    }
}
