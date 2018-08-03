<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class StaffSpouse extends Model
{
    protected $table = 'staff_spouses';

    public function belongtostaff()
    {
    	return $this->belongsTo('App\Staff', 'staff_id');
    }
}
