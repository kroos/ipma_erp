<?php

namespace App\Http\Controllers\Sales;

// to link back from controller original
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SalesMarketingDepartmentController extends Controller
{
	// must always refer to php artisan route:list
	function __construct()
	{
		$this->middleware('auth');
		$this->middleware('deptaccess');
	}

	public function index()
	{
		return view('marketingAndBusinessDevelopment.sales-marketing.index');
	}
}
