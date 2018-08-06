<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class CategoryPosition extends Model
{
    protected $table = 'categories_positions';

    public function belongtocategory()
    {
    	return $this->belongsTo('App\Model\Category', 'category_id');
    }

    public function belongtoposition()
    {
    	return $this->belongsTo('App\Model\Position', 'position_id');
    }
}
