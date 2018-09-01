<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;

// load model
use App\Model\StaffLeave;

use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffLeaveRequest;

use Session;


class StaffLeaveController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		$this->middleware('leaveaccess', ['only' => ['show', 'edit', 'update']]);
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		return view('leave.index');
		// SELECT leave_no, leave_created_date from `leave` WHERE YEAR(leave_created_date)='2019' ORDER BY leave_id DESC LIMIT 1
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('leave.create');
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(StaffLeaveRequest $request)
	{
		// $fridays = [];
		// $startDate = Carbon::parse('2018-08-01')->next(Carbon::SUNDAY); // Get the first sunday.
		// $endDate = Carbon::parse('2018-08-31');

		// for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
		//     $fridays[] = $date->format('Y-m-d');
		// }
		// echo count($fridays);

		// dd( $request->all() );

		// $nodate = \App\Model\HolidayCalendar::orderBy('date_start')->get();
		// foreach ($nodate as $nda) {
		// 	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
		// 	foreach ($period as $key) {
		// 		echo $key->format('Y-m-d');
		// 	}
		// }

		// in time off, there only date_time_start so...
		if( empty( $request->date_time_end ) ) {
			$request->date_time_end = $request->date_time_start;
		}

		$period = \Carbon\CarbonPeriod::create($request->date_time_start, '1 days', $request->date_time_end);
		foreach ($period as $key) {
			// echo $key->format('Y-m-d');
			$kik = StaffLeave:: where( 'staff_id', \Auth::user()->belongtostaff->id )->where('active', 1)->whereRaw('? BETWEEN DATE(date_time_start) AND DATE(staff_leaves.date_time_end)', [$key->format('Y-m-d')])->get();
			if( $kik->count() > 0 ) {
				Session::flash('flash_message', 'Tarikh permohonan cuti ('.\Carbon\Carbon::parse($request->date_time_start)->format('D, j F Y').' hingga '.\Carbon\Carbon::parse($request->date_time_end)->format('D, j F Y').') sudah diisi, sila ambil tarikh yang lain');
				return redirect()->back();
			}
		}

		// walau apa cuti sekalipon, mai kita check cuti bertindih dulu..



		// 		$request->reason
		// 		$request->date_time_start
		// 		$request->date_time_end
		// 		$request->leave_type
		// 		$request->leave_half
		// 		$request->staff_id
		// 		$request->time_start
		// 		$request->time_end
		// 		$request->file('document')
		// 		$request->documentsupport
		// 		$request->akuan

		// first, we must check $reaquest->leave_type. if $request->leave_type == 1? full day(1) : half day(2)

		// if ( $request->leave_id == 1 || $request->leave_id == 3 ) {
			// insert semua apa yg ada
			// StaffLeave::create( array_add( $request->except(['_method', '_token']), 'staff_id', auth()->user()->belongtostaff->id) );
			// Session::flash('flash_message', 'Data successfully inserted!');
			// return redirect()->back();
		// }

		// if ( $request->leave_id == 2 ) {
		// }

		// if ( $request->leave_id == 4 ) {
		// }

		// if ( $request->leave_id == 7 ) {
		// }

		// if ( $request->leave_id == 8 ) {
		// }

		// if ( $request->leave_id == 9 ) {
		// }
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show(StaffLeave $staffLeave)
	{
		//
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(StaffLeave $staffLeave)
	{
		//
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, StaffLeave $staffLeave)
	{
		//
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(StaffLeave $staffLeave)
	{
		//
	}
}
