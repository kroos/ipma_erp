<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class LockerStatus extends Model
{
	protected $table = 'locker_statuses';
    public function hasmanylocker()
    {
    	return $this->hasMany('App\Locker');
    }
}
