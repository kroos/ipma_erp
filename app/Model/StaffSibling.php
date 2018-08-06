<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffSibling extends Model
{
    protected $table = 'staff_siblings';

    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff');
    }
}
