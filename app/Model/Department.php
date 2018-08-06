<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // protected $table = 'departments';

    public function belongtodivision() {
    	return $this->belongsTo('App\Model\Division', 'division_id');
    }
}
