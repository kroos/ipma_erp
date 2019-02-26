<?php

namespace App\Http\Controllers\Administrative\HumanResource\StaffManagement;

use App\Http\Controllers\Controller;

// load model
use App\Model\StaffMemo;

use Illuminate\Http\Request;

use Session;

class StaffMemoController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		// echo 'index';
	}

	public function create()
	{
		return view('generalAndAdministrative.hr.staffmanagement.warning.create');
	}

	public function store(Request $request)
	{
		StaffMemo::create($request->except(['_token']));
		Session::flash('flash_message', 'Data successfully saved!');
		return redirect( route('staffDis.index') );
	}

	public function show(StaffMemo $staffMemo)
	{
		echo 'show';
	}

	public function edit(StaffMemo $staffMemo)
	{
		return view('generalAndAdministrative.hr.staffmanagement.warning.edit', compact(['staffMemo']));
	}

	public function update(Request $request, StaffMemo $staffMemo)
	{
		$staffMemo->update($request->except(['_token', '_method']));
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staffDis.index') );
	}

	public function destroy(StaffMemo $staffMemo)
	{
		StaffMemo::destroy($staffMemo->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
