<?php

namespace App\Http\Controllers\Administrative\HumanResource\LeaveEditing;

use App\Http\Controllers\Controller;

use App\Model\StaffLeave;
use Illuminate\Http\Request;

use Session;
use \Carbon\Carbon;

class StaffLeaveHRController extends Controller
{
	public function __construct()
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

	public function show(StaffLeave $staffLeaveHR)
	{
		//
	}

	public function edit(StaffLeave $staffLeaveHR)
	{
		return view('generalAndAdministrative.hr.leave.leavelist.edit', compact(['staffLeaveHR']));
	}

	public function update(Request $request, StaffLeave $staffLeaveHR)
	{
		// print_r ($request->all());

		// checking for half day
		if( $request->leave_type == 1 || empty($request->leave_type) ) {
			$time_start = ' 00:00:00';
			$time_end = ' 00:00:00';

			$date_time_start = $request->date_time_start.' '.$time_start;
			$date_time_end = $request->date_time_end.' '.$time_end;

		} else {
			if($request->leave_type == 2) {
				// leave_type = 2, means half day leave
				$time = explode( '/', $request->leave_half );
				$time_start = $time[0];
				$time_end = $time[1];

				$date_time_start = $request->date_time_start.' '.$time_start;
				$date_time_end = $request->date_time_end.' '.$time_end;
			}
		}

		$per = $staffLeaveHR->period;

		if( $staffLeaveHR->leave_id == 9 ) {	// time off
		
			$tim1 = \Carbon\Carbon::create($request->date_time_start.' '.$request->time_start, 'Y-m-d h:m A');
			$tim2 = \Carbon\Carbon::create($request->date_time_start.' '.$request->time_end, 'Y-m-d h:m A');

			if ( $tim1->gte($tim2) ) { // time start less than time end
				Session::flash('flash_message', 'Masa bagi permohonon Time Off tidak dapat diproses ('.\Carbon\Carbon::parse($request->date_time_start.' '.$request->time_start)->format('D, j F Y h:i A').' hingga '.\Carbon\Carbon::parse($request->date_time_start.' '.$request->time_end)->format('D, j F Y h:i A').') . Sila ambil masa yang lain.');
				return redirect()->back()->withInput();
			}

			$staffLeaveHR->update([
						'remarks' => $request->remarks,
						'date_time_start' => $tim1,
						'date_time_end' => $tim2,
						'period' => $request->period,
			]);
		}

		if( $staffLeaveHR->leave_id == 1 || $staffLeaveHR->leave_id == 5 ) {	// al and el-al
			//get the annual leave balance
			$al = $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->annual_leave_balance;
			$alle = $al + $per - $request->period;

			if( $alle < 0 ) {
				Session::flash('flash_message', 'Masa bagi permohonon ini tidak dapat diproses kerana tempoh baki Cuti Tahunan sudah habis digunakan ('.$alle.') hari. Sila ambil masa yang lain.');
				return redirect()->back()->withInput();
			} else {
				$staffLeaveHR->update([
							'remarks' => $request->remarks,
							'date_time_start' => $date_time_start,
							'date_time_end' => $date_time_end,
							'half_day' => $request->leave_type,
							'period' => $request->period,
							'al_balance' => $request->balance,
				]);
				// update staff balance annual.
				$staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->update([
					'annual_leave_balance' => $request->balance,
				]);
			}
		}
	
		if( $staffLeaveHR->leave_id == 2 ) {
			//get the annual leave balance
			$mc = $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->medical_leave_balance;
			$alle = $mc + $per - $request->period;

			if( $alle < 0 ) {
				Session::flash('flash_message', 'Masa bagi permohonon ini tidak dapat diproses kerana tempoh baki Cuti Sakit sudah habis digunakan ('.$alle.') hari. Sila ambil masa yang lain.');
				return redirect()->back()->withInput();
			} else {
				$staffLeaveHR->update([
							'remarks' => $request->remarks,
							'date_time_start' => $date_time_start,
							'date_time_end' => $date_time_end,
							'half_day' => $request->leave_type,
							'period' => $request->period,
							'mc_balance' => $request->balance,
				]);
				// update staff balance annual.
				$staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->update([
					'medical_leave_balance' => $request->balance,
				]);
			}
		}

		if( $staffLeaveHR->leave_id == 3 || $staffLeaveHR->leave_id == 6 || $staffLeaveHR->leave_id == 11 ) {
			$staffLeaveHR->update([
						'remarks' => $request->remarks,
						'date_time_start' => $date_time_start,
						'date_time_end' => $date_time_end,
						'half_day' => $request->leave_type,
						'period' => $request->period,
			]);
		}

		if( $staffLeaveHR->leave_id == 7 ) {
			$ml = $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->maternity_leave_balance;
			$alle = $ml + $per - $request->period;
			if( $alle < 0 ) {
				Session::flash('flash_message', 'Masa bagi permohonon ini tidak dapat diproses kerana tempoh baki Cuti Bersalin sudah habis digunakan ('.$alle.') hari. Sila ambil masa yang lain.');
				return redirect()->back()->withInput();
			} else {
				$staffLeaveHR->update([
							'remarks' => $request->remarks,
							'date_time_start' => $date_time_start,
							'date_time_end' => $date_time_end,
							'half_day' => $request->leave_type,
							'period' => $request->period,
				]);
				// update staff balance annual.
				$staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->update([
					'maternity_leave_balance' => $request->balance,
				]);
			}
		}

		if( $staffLeaveHR->leave_id == 4 ) {
			$nl = $staffLeaveHR->hasmanystaffleavereplacement()->first()->leave_balance;
			$nlb = $staffLeaveHR->hasmanystaffleavereplacement()->first()->leave_total;
			$alle = $nl + $per - $request->period;
			if( $alle < 0 ) {
				Session::flash('flash_message', 'Masa bagi permohonon ini tidak dapat diproses kerana tempoh baki Cuti Ganti sudah habis digunakan ('.$alle.') hari. Sila ambil masa yang lain.');
				return redirect()->back()->withInput();
			} else {
				$staffLeaveHR->update([
							'remarks' => $request->remarks,
							'date_time_start' => $date_time_start,
							'date_time_end' => $date_time_end,
							'half_day' => $request->leave_type,
							'period' => $request->period,
				]);
				// update staff balance annual.

				$staffLeaveHR->hasmanystaffleavereplacement()->update([
					'leave_utilize' => $nlb - $request->balance,
					'leave_balance' => $request->balance,
				]);
			}
		}
		Session::flash('flash_message', 'Data successfully inserted.');
		return redirect()->route('leaveEditing.index');
	}

	public function updateRHC(Request $request)
	{
		if($request->has('hardcopy')) {
			foreach ($request->hardcopy as $key) {
				StaffLeave::where('id', $key)->update(['hardcopy' => 1]);
			}
			Session::flash('flash_message', 'Data successfully inserted.');
			return redirect()->route('leaveEditing.index');
		}
		if($request->has('closed')) {
			foreach ($request->closed as $key) {
				StaffLeave::where('id', $key)->update(['active' => 2]);
			}
			Session::flash('flash_message', 'Data successfully inserted.');
			return redirect()->route('leaveEditing.index');
		}
		Session::flash('flash_message', 'Please click on the checkbox. There is no data passed to the system.');
		return redirect()->route('leaveEditing.index');
	}

	public function destroy(StaffLeave $staffLeaveHR)
	{
	//
	}
}
