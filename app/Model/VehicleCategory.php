<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{
	protected $connection = 'mysql';
    protected $table = 'vehicle_categories';

    public function hasmanyvehicle()
    {
    	return $this->hasMany('App\Model\Vehicle');
    }
}
