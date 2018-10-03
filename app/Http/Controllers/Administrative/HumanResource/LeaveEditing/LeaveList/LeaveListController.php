<?php

namespace App\Http\Controllers\Administrative\HumanResource\LeaveEditing\LeaveList;

use App\Http\Controllers\Controller;

use App\Model\StaffLeave;
use App\Model\StaffLeaveBackup;
use App\Model\StaffLeaveApproval;
use App\Model\StaffAnnualMCLeave;
use App\Model\StaffLeaveReplacement;


use Illuminate\Http\Request;

class LeaveListController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('generalAndAdministrative.hr.leave.leavelist.index');
	}

	public function create()
	{
	//
	}

	public function store(Request $request)
	{
	//
	}

	public function show(StaffLeave $staffLeave)
	{
	//
	}

	public function edit(StaffLeave $staffLeave)
	{
	}

	public function update(Request $request, StaffLeave $staffLeave)
	{
	//
	}

	public function destroy(StaffLeave $staffLeave)
	{
	//
	}
}
