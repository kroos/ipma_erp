<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
	protected $connection = 'mysql';
    protected $table = 'ics_charges';

    // public function hasmanyvehicle()
    // {
    // 	return $this->hasMany('App\Model\Vehicle');
    // }
}
