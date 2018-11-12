<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
	protected $connection = 'mysql';
    protected $table = 'educations_levels';

    public function hasmanystaffchildren()
    {
    	return $this->hasMany('App\Model\StaffChildren');
    }


}
