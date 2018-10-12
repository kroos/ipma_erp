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

	public function show(StaffLeaveReplacement $staffLeaveReplacement)
	{
	//
	}

	public function edit(StaffLeaveReplacement $staffLeaveReplacement)
	{
		return view('generalAndAdministrative.hr.leave.nrl.edit', compact(['staffLeaveReplacement']));
	}

	public function update(Request $request, StaffLeaveReplacement $staffLeaveReplacement)
	{
		print_r( $request->except(['_method', '_token']) );
		$staffLeaveReplacement->update( $request->except(['_method', '_token']) );
		Session::flash('flash_message', 'Data successfully updated.');
		return redirect()->route('leaveNRL.index');
	}

	public function destroy(StaffLeaveReplacement $staffLeaveReplacement)
	{
		$staffLeaveReplacement->destroy($staffLeaveReplacement->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
