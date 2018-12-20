<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
	protected $connection = 'mysql';
	protected $table = 'disciplines';

// https://laravel.com/docs/5.6/eloquent-relationships#many-to-many
    // public function belongtomanystaff()
    // {
    // 	return $this->belongsToMany('App\Model\Staff', 'staff_disciplines', 'staff_id', 'position_id' )->withPivot('remarks')->withPivot('id')->withTimestamps();
    // }
}
