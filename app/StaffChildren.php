<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class StaffChildren extends Model
{
    public function belongtostaff()
    {
    	return $this->belongsTo('App\Staff', 'staff_id');
    }

    public function belongtogender()
    {
    	return $this->belongsTo('App\Gender', 'gender_id');
    }

    public function belongtoeducationlevel()
    {
    	return $this->belongsTo('App\EducationLevel', 'education_level_id');
    }

    public function belongtohealthstatus()
    {
    	return $this->belongsTo('App\HealthStatus', 'health_status_id');
    }

    public function belongtotaxexemptionpercentage()
    {
    	return $this->belongsTo('App\TaxExamptionPercentage', 'tax_examption_percentage_id');
    }
}
