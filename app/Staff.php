<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
	public function hasmanylogin()
	{
		return $this->hasMany('App\Login', 'staff_id');
	}
}
