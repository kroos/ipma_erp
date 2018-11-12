<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;
// load Model
// use App\Model\Status;


use Illuminate\Database\Eloquent\SoftDeletes;

class StaffTCMS extends Model
{
	use SoftDeletes;

    protected $connection = 'mysql';
	protected $table = 'staff_tcms';
	protected $dates = ['deleted_at'];

    // protected $primaryKey = ['staff_id', 'date'];

    // public $incrementing = false;
    // protected $keyType = string;

    // hasmany

/////////////////////////////////////////////////////////////////////////////////////////////////////
    // belongto
    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff', 'staff_id');
    }

}
