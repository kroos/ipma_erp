<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class HealthStatus extends Model
{
	protected $connection = 'mysql';
    protected $table = 'health_statuses';

    public function hasmanystaffchildren()
    {
    	return $this->hasMany('App\Model\StaffChildren');
    }


}
