<?php

namespace App\Http\Controllers\Administrative\HumanResource;

// to link back from controller original
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PrintStaffLeaveController extends Controller
{
	// must always refer to php artisan route:list
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('generalAndAdministrative.account.index');
	}
}
