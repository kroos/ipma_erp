<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class CategoryPosition extends Model
{
    protected $table = 'categories_positions';

    public function belongtocategory()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function belongtoposition()
    {
    	return $this->belongsTo('App\Position', 'position_id');
    }
}
