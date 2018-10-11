<?php

namespace App\Http\Controllers\Administrative\HumanResource\LeaveEditing\NRL;

use App\Http\Controllers\Controller;

use App\Model\StaffLeave;
use App\Model\StaffLeaveReplacement;


use Illuminate\Http\Request;

use Session;

class StaffLeaveReplacementController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
	}

	public function create()
	{
		return view('generalAndAdministrative.hr.leave.nrl.create');
	}

	public function store(Request $request)
	{
		// print_r($request->all());
		// $l = StaffLeaveReplacement::insert( $request->staff );
		foreach ($request->staff as $key => $v) {
			$l = StaffLeaveReplacement::create( $v );
		}
		Session::flash('flash_message', 'Data successfully inserted.');
		return redirect()->route('leaveNRL.index');
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
