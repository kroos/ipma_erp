<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;

class ICSSQLSRVInvoiceDTL extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dbo.IVDTL';
	protected $primaryKey = 'DtlKey';



	public function belongtoinvoice()
	{
		return $this->belongsTo('App\Model\ICSSQLSRVInvoice', 'DocKey');
	}
}
