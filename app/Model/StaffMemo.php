<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class StaffMemo extends Model
{
	protected $connection = 'mysql';
	protected $table = 'staff_memos';

	public function belongtostaff()
	{
		return $this->belongsTo('App\Model\Staff', 'staff_id');
	}

	public function belongtomemocategory()
	{
		return $this->belongsTo('App\Model\MemoCategory', 'memo_category');
	}
}
