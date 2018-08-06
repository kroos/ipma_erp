<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class LockerStatus extends Model
{
	protected $table = 'locker_statuses';
	
    public function hasmanylocker()
    {
    	return $this->hasMany('App\Model\Locker');
    }
}
