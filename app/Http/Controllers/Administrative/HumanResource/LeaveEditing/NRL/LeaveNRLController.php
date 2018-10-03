<?php

namespace App\Http\Controllers\Administrative\HumanResource\LeaveEditing\NRL;

use App\Http\Controllers\Controller;

use App\Model\StaffLeave;
use App\Model\StaffLeaveBackup;
use App\Model\StaffLeaveApproval;
use App\Model\StaffAnnualMCLeave;
use App\Model\StaffLeaveReplacement;


use Illuminate\Http\Request;

class LeaveNRLController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		// return view('generalAndAdministrative.hr.leave.nrl.index');
	}

	public function create()
	{
	//
	}

	public function store(Request $request)
	{
	//
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
