<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    protected $connection = 'mysql';
	protected $table = 'lockers';

    public function belongtolockerstatus()
    {
    	return $this->belongsTo('App\Model\LockerStatus', 'locker_status_id');
    }

    public function belongtocategory()
    {
    	return $this->belongsTo('App\Model\Category', 'category_id');
    }

    public function belongtolocation()
    {
    	return $this->belongsTo('App\Model\Location', 'location_id');
    }
}
