<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $connection = 'mysql';
    protected $table = 'groups';

    public function hasmanyposition()
    {
    	return $this->hasMany('App\Model\Position', 'group_id');
    }
}
