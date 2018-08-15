<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';

// https://laravel.com/docs/5.6/eloquent-relationships#many-to-many
    public function belongtomanystaff()
    {
    	return $this->belongsToMany('App\Model\Staff', 'staff_positions', 'staff_id', 'position_id' )->withPivot('main')->withTimestamps();
    }

    public function belongtodivision()
    {
    	return $this->belongsTo('App\Model\Division', 'division_id');
    }

    public function belongtodepartment()
    {
    	return $this->belongsTo('App\Model\Department', 'department_id');
    }

    public function belongtogroup()
    {
        return $this->belongsTo('App\Model\Group', 'group_id');
    }

    public function belongtocategory()
    {
        return $this->belongsTo('App\Model\Category', 'category_id');
    }
}
