<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $connection = 'mysql';
    protected $table = 'categories';

    public function hasmanycategoryposition()
    {
    	return $this->hasMany('App\Model\CategoryPosition');
    }

    public function hasmanylocker()
    {
    	return $this->hasMany('App\Model\Locker');
    }

    
}
