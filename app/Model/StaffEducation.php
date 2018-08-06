<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffEducation extends Model
{
    protected $table = 'staffs_educations';

    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff', 'staff_id');
    }
}
