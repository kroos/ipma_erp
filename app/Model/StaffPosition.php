<?php
// pivot table
namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffPosition extends Model
{
	protected $connection = 'mysql';
    protected $table = 'staff_positions';

    public function belongtostaff()
    {
    	return $this->belongsTo('\App\Model\Staff', 'staff_id');
    }

    public function belongtoposition()
    {
    	return $this->belongsTo('App\Model\Position', 'position_id');
    }
}
