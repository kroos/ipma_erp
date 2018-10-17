<?php

namespace App\Http\Controllers\Administrative\HumanResource\TCMS;

use App\Http\Controllers\Controller;

// load model
use App\Model\StaffTCMS;

use Illuminate\Http\Request;

class StaffTCMSController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		// return view('generalAndAdministrative.hr.tcms.index');
	}

	public function create()
	{
	//
	}

	public function store(Request $request)
	{
	
	}

	public function show(Leave $leave)
	{
	//
	}

	public function edit(Leave $leave)
	{
	//
	}

	public function update(Request $request, Leave $leave)
	{
	//
	}

	public function destroy(Leave $leave)
	{
	//
	}
}
