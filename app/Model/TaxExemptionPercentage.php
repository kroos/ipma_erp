<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class TaxExemptionPercentage extends Model
{
    protected $table = 'tax_exemption_percentage';

	public function hasmanystaffchildren()
    {
    	return $this->hasMany('App\Model\StaffChildren');
    }


}
