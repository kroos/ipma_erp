<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
	protected $connection = 'mysql';
    protected $table = 'marital_statuses';

    public function hasmanystaff()
    {
    	return $this->hasMany('App\Model\Staff');
    }
}
