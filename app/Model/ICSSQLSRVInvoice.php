<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSSQLSRVInvoice extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dbo.IV';
	protected $primaryKey = 'DocKey';

	public function hasoneservicereport()
	{
		return $this->hasOne('App\Model\ICSServiceReport', 'invoice_id');
	}
}
