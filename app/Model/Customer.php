<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $connection = 'mysql';
    protected $table = 'customers';

    public function hasmanyservicereport()
    {
    	return $this->hasMany('App\Model\ICSServiceReport');
    }
}
