<?php

namespace App\Http\Controllers\Administrative\HumanResource\StaffManagement;

use App\Http\Controllers\Controller;

// load model
use App\Model\Staff;

use Illuminate\Http\Request;

use Session;

class StaffResignController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('generalAndAdministrative.hr.staffmanagement.resign.index');
	}

	public function create()
	{
	}

	public function store(Request $request)
	{
	}

	public function show(Staff $staffResign)
	{
	}

	public function edit(Staff $staffResign)
	{
		return view('generalAndAdministrative.hr.staffmanagement.resign.edit', compact(['staffResign']));
	}

	public function update(Request $request, Staff $staffResign)
	{
		$staffResign->update($request->except(['_token', '_method']));
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staffResign.index') );
	}

	public function destroy(Staff $staffResign)
	{
	}
}
