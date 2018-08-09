<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffChildren extends Model
{
    protected $table = 'staff_childrens';

    public function belongtostaff()
    {
    	return $this->belongsTo('App\Model\Staff', 'staff_id');
    }

    public function belongtogender()
    {
    	return $this->belongsTo('App\Model\Gender', 'gender_id');
    }

    public function belongtoeducationlevel()
    {
    	return $this->belongsTo('App\Model\EducationLevel', 'education_level_id');
    }

    public function belongtohealthstatus()
    {
    	return $this->belongsTo('App\Model\HealthStatus', 'health_status_id');
    }

    public function belongtotaxexemptionpercentage()
    {
    	return $this->belongsTo('App\Model\TaxExemptionPercentage', 'tax_exemption_percentage_id');
    }
}
