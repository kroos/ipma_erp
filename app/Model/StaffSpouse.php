<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffSpouse extends Model
{
    protected $table = 'staff_spouses';

    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff', 'staff_id');
    }
}
