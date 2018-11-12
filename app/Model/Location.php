<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	protected $connection = 'mysql';
    protected $table = 'locations';

    public function hasonestaff()
    {
    	$this->hasOne('App\Model\Staff', 'location_id');
    }
}
