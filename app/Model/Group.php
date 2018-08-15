<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public function hasmanyposition()
    {
    	return $this->hasMany('App\Model\Position', 'group_id');
    }
}
