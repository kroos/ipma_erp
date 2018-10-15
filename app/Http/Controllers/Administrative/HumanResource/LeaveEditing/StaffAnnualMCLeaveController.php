<?php

namespace App\Http\Controllers\Administrative\HumanResource\LeaveEditing;

use App\Model\StaffAnnualMCLeave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;

class StaffAnnualMCLeaveController extends Controller
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
		return view('generalAndAdministrative.hr.leave.settings.create');
	}

	public function store(Request $request)
	{
		StaffAnnualMCLeave::create( $request->except(['_method', '_token']) );
		Session::flash('flash_message', 'Data successfully update.');
		return redirect()->route('leaveSetting.index');
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////
	// custom insert
	public function storeALMCML(Request $request)
	{
		$no = $request->almcmly - 1;
		$s2 = StaffAnnualMCLeave::where('year', $request->almcmly - 1)->get();

		foreach ($s2 as $k) {
			if( $k->belomgtostaff->active == 1 ) {

				$k->where('year', $request->almcmly)->updateOrCreate([
					'staff_id' => $k->staff_id,
					'year' => $request->almcmly,
					'annual_leave' => $k->annual_leave,
					'annual_leave_adjustment' => $k->annual_leave_adjustment,
					'annual_leave_balance' => $k->annual_leave_balance,
					'medical_leave' => $k->medical_leave,
					'medical_leave_adjustment' => $k->medical_leave_adjustment,
					'medical_leave_balance' => $k->medical_leave_balance,
					'maternity_leave' => $k->maternity_leave,
					'maternity_leave_balance' => $k->maternity_leave_balance,
				]);
			}
		}
		// StaffAnnualMCLeave::updateOrCreate([]);
		return response()->json([
									'message' => 'Completed generate AL, MC and ML for all active user in next year.',
									'status' => 'success'
								]);
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////
	public function show(StaffAnnualMCLeave $staffAnnualMCLeave )
	{
	}

	public function edit(StaffAnnualMCLeave $staffAnnualMCLeave)
	{
		return view('generalAndAdministrative.hr.leave.settings.edit', compact(['staffAnnualMCLeave']));
	}

	public function update(Request $request, StaffAnnualMCLeave $staffAnnualMCLeave)
	{
		$staffAnnualMCLeave->update($request->except( ['_method', '_token'] ));
		Session::flash('flash_message', 'Data successfully update.');
		return redirect()->route('leaveSetting.index');
	}

	public function destroy(StaffAnnualMCLeave $staffAnnualMCLeave)
	{
		$staffAnnualMCLeave->destroy( $staffAnnualMCLeave->id );
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
