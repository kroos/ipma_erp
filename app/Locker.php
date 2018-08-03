<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
	protected $table = 'lockers';

    public function belongtolockerstatus()
    {
    	return $this->belongsTo('App\LockerStatus', 'locker_status_id');
    }

    public function belongtocategory()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function belongtolocation()
    {
    	return $this->belongsTo('App\Location', 'location_id');
    }
}
