<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TaxExamptionPercentage extends Model
{
    protected $table = 'tax_examption_percentages';

	public function hasmanystaffchildren()
    {
    	return $this->hasMany('App\Model\StaffChildren');
    }


}
