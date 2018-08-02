<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
	protected $table = 'staffs';
	public function hasmanylogin()
	{
		return $this->hasMany('App\Login');
	}
}
