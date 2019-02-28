<?php

namespace App\Http\Controllers\Administrative\HumanResource\StaffManagement;

use App\Http\Controllers\Controller;

// load model
use App\Model\StaffDisciplinaryAction;

use Illuminate\Http\Request;

use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class StaffDisciplinaryActionController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('generalAndAdministrative.hr.staffmanagement.disciplinary_action.index');
	}

	public function create()
	{
		return view('generalAndAdministrative.hr.staffmanagement.disciplinary_action.create');
	}

	public function store(Request $request)
	{
		StaffDisciplinaryAction::create($request->except(['_token']));
		Session::flash('flash_message', 'Data successfully saved!');
		return redirect( route('staffDisciplinaryAct.index') );
	}

	public function show(StaffDisciplinaryAction $staffDisciplinaryAct)
	{
		// echo 'show';
	}

	public function edit(StaffDisciplinaryAction $staffDisciplinaryAct)
	{
		return view('generalAndAdministrative.hr.staffmanagement.disciplinary_action.edit', compact(['staffDisciplinaryAct']));
	}

	public function update(Request $request, StaffDisciplinaryAction $staffDisciplinaryAct)
	{
		$staffDisciplinaryAct->update($request->except(['_token', '_method']));
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staffDisciplinaryAct.index') );
	}

	public function destroy(StaffDisciplinaryAction $staffDisciplinaryAct)
	{
		StaffDisciplinaryAction::destroy($staffDisciplinaryAct->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
