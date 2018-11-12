<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	protected $connection = 'mysql';
    protected $table = 'statuses';

    public function hasmanystatus()
    {
    	return $this->hasOne('App\Model\Staff');
    }

}
