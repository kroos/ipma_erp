<?php

namespace App\Http\Controllers\Administrative\HumanResource\TCMS;

use App\Http\Controllers\Controller;

// load model
use App\Model\StaffTCMS;

use Illuminate\Http\Request;

use \Carbon\Carbon;
use Session;

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
		return view('generalAndAdministrative.hr.tcms.create');
	}

	public function storeODBC(Request $request)
	{
	
	}

	public function storeCSV(Request $request)
	{
	
	}

	public function store(Request $request)
	{
	
	}

	public function show(StaffTCMS $staffTCMS)
	{
	//
	}

	public function edit(Request $request, StaffTCMS $staffTCMS)
	{
		$date = $request->date;
		// print_r( $request->segments(1) );
		// echo $request->segment(2);
		$staff_id = $request->segment(2);
		return view('generalAndAdministrative.hr.tcms.edit', compact(['staffTCMS', 'date', 'staff_id']));
	}

	public function update(Request $request, StaffTCMS $staffTCMS)
	{
		// echo $request->date.' <br />';
		// echo $request->segment(2);
		// print_r( $request->all() );

		$in = Carbon::parse($request->in)->format('H:i:s');
		$break = Carbon::parse($request->break)->format('H:i:s');
		$resume = Carbon::parse($request->resume)->format('H:i:s');
		$out = Carbon::parse($request->out)->format('H:i:s');

		echo $in;

		$staffTCMS = StaffTCMS::where([ ['staff_id', $request->segment(2)],	['date', $request->date] ]);

		$staffTCMS->update([
								'in' => $in,
								'break' => $break,
								'resume' => $resume,
								'out' => $out,
								'leave_taken' => $request->leave_taken,
								'remark' => $request->remark,
								'exception' => $request->exception,
		]);

		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('tcms.index') );
	}

	public function destroy(StaffTCMS $staffTCMS)
	{
	//
	}
}
