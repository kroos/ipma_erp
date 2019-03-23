<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
	protected $connection = 'mysql';
    protected $table = 'currencies';

    public function hasmanyquot()
    {
    	return $this->hasMany('App\Model\StaffProfile');
    }
}
