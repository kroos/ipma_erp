<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class MemoCategory extends Model
{
	protected $connection = 'mysql';
	protected $table = 'memo_categories';

	public function hasmanystaffmemo()
	{
		return $this->hasMany('\App\Model\StaffMemo', 'memo_category');
	}

	// public function belongtostaff()
	// {
	// 	return $this->belongsTo('App\Model\Staff', 'staff_id');
	// }
}
