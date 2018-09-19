<?php

namespace App\Http\Controllers\Administrative\HumanResource\LeaveEditing;

use App\Model\StaffLeave;
use App\Model\StaffLeaveBackup;
use App\Model\StaffLeaveApproval;
use App\Model\StaffAnnualMCLeave;
use App\Model\StaffLeaveReplacement;


use Illuminate\Http\Request;

class LeaveEditingController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
	//
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
