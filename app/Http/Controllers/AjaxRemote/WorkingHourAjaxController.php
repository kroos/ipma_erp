<?php

namespace App\Http\Controllers\AjaxRemote;

use App\Http\Controllers\Controller;

use App\Model\WorkingHour;
use App\Model\StaffEmergencyPersonPhone;
use App\Model\HolidayCalendar;

use Illuminate\Http\Request;

class WorkingHourAjaxController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function workingtime(Request $request)
	{
		$userposition = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
		$dt = \Carbon\Carbon::parse($request->date);

		// echo $userposition->id; // 60
		// echo $dt->year; // 2019
		// echo $dt->dayOfWeek; // dayOfWeek returns a number between 0 (sunday) and 6 (saturday) // 5

		if( $userposition->id == 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
			$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
		} else {
			if ( $userposition->id == 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
				$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
			} else {
				if( $userposition->id != 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
					// normal
					$time = \App\Model\WorkingHour::where('year', $dt->year)->whereRaw('"'.$request->date.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
				} else {
					if( $userposition->id != 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
						$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 3)->whereRaw('"'.$request->date.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
					}
				}
			}
		}
 		// echo $time->toSql();

		return response()->json([
			'start_am' => $time->first()->time_start_am,
			'end_am' => $time->first()->time_end_am,
			'start_pm' => $time->first()->time_start_pm,
			'end_pm' => $time->first()->time_end_pm,
		]);
	}

	public function leaveType(Request $request)
	{
		$year = \Carbon\Carbon::parse($request->date)->year;

		// checking for annual leave, mc, nrl and maternity
		// hati-hati dgn yg ni sbb melibatkan masa
		$leaveALMC = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->where('year', date('Y'))->first();
		$oi = \Auth::user()->belongtostaff->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->whereYear('working_date', date('Y'))->get();
		$ty = \Auth::user()->belongtostaff;
		// dd($oi->sum('leave_balance'));
		
		// geng laki
		if($ty->gender_id == 1) {
			// geng laki | no nrl
			if( empty( $oi->sum('leave_balance') ) || $oi->sum('leave_balance') < 1 ) {
				// geng laki | no nrl | no al 
				if( $leaveALMC->annual_leave_balance < 1 ) {
					if ($leaveALMC->medical_leave_balance < 1) {
			
						// laki | no nrl | no al | no mc
						$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 4)->where('id', '<>', 1)->where('id', '<>', 2)->get();
					} else {
		
						// laki | no nrl | no al | with mc
						$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 4)->where('id', '<>', 1)->where('id', '<>', 11)->get();
					}
				} else {
					if ($leaveALMC->medical_leave_balance < 1) {
		
						// laki | no nrl | with al | no mc
						$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 3)->where('id', '<>', 2)->get();
					} else {
		
						// laki | no nrl | with al | with mc
						$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 3)->where('id', '<>', 11)->get();
					}
				}
			} else {
				if( $leaveALMC->annual_leave_balance < 1 ) {
					if ($leaveALMC->medical_leave_balance < 1) {
		
						// laki | with nrl | no al | no mc
						$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 1)->where('id', '<>', 2)->get();
					} else {
		
						// laki | with nrl | no al | with mc
						$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 1)->where('id', '<>', 11)->get();
					}
				} else {
					if ($leaveALMC->medical_leave_balance < 1) {
		
						// laki | with nrl | with al | no mc
						$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 3)->where('id', '<>', 2)->get();
					} else {
		
						// laki | with nrl | with al | with mc
						$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 3)->where('id', '<>', 11)->get();
					}
				}
			}
		} else {
		
			// geng pempuan
			if($ty->gender_id == 2) {
				// pempuan | no nrl
				if($oi->sum('leave_balance') < 1 ) {
					if( $leaveALMC->annual_leave_balance < 1 ) {
						if ($leaveALMC->medical_leave_balance < 1) {
		
							// pempuan | no nrl | no al | no mc
							$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 4)->where('id', '<>', 1)->where('id', '<>', 2)->get();
						} else {
		
							// pempuan | no nrl | no al | with mc
							$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 4)->where('id', '<>', 1)->where('id', '<>', 11)->get();
						}
					} else {
						if ($leaveALMC->medical_leave_balance < 1) {
		
							// pempuan | no nrl | with al | no mc
							$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 4)->where('id', '<>', 3)->where('id', '<>', 2)->get();
						} else {
		
							// pempuan | no nrl | with al | with mc
							$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 4)->where('id', '<>', 3)->where('id', '<>', 11)->get();
						}
					}
				} else {
				// pempuan | with nrl
					if( $leaveALMC->annual_leave_balance < 1 ) {
						if ($leaveALMC->medical_leave_balance < 1) {
		
							// pempuan | with nrl | no al | no mc
							$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 1)->where('id', '<>', 2)->get();
						} else {
		
							// pempuan | with nrl | no al | with mc
							$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 1)->where('id', '<>', 11)->get();
						}
					} else {
						if ($leaveALMC->medical_leave_balance < 1) {
		
							// pempuan | with nrl | with al | no mc
							$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 3)->where('id', '<>', 2)->get();
						} else {
		
							// pempuan | with nrl | with al | with mc
							$er = \App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 3)->where('id', '<>', 11)->get();
						}
					}
				}
			}
		}

		// https://select2.org/data-sources/formats
		foreach ($er as $key) {
			$cuti['results'][] = [
					'id' => $key->id,
					'text' => $key->leave,
					'created_at' => $key->created_at,
			];
			// $cuti['pagination'] = ['more' => true];
		}
		return response()->json( $cuti );
	}

	public function blockholidaysandleave()
	{
		$holiday = array();
		$nodate = \App\Model\HolidayCalendar::all();
		foreach ($nodate as $nda) {
			$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
			foreach ($period as $key) {
				// echo 'moment("'.$key->format('Y-m-d').'"),';
				// $holiday[] = '"'.$key->format('Y-m-d').'"';
				$holiday1[] = $key->format('Y-m-d');
			}
		}
		// block cuti sendiri
		$nodate1 = \Auth::user()->belongtostaff->hasmanystaffleave()->where('active', 1)->whereRaw( '"'.date('Y').'" BETWEEN YEAR(date_time_start) AND YEAR(date_time_end)' )->get();
		if(is_null($nodate1)) {
			foreach ($nodate1 as $key) {
				$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
				foreach ($period1 as $key1) {
					$holiday2[] = $key1->format('Y-m-d');
				}
			}
		}
		$holiday2 = array();
		// $hnleave = "[moment('".implode("', 'YYYY-MM-DD'), moment('", $holiday)."', 'YYYY-MM-DD')";
		// $hnleave = '["'.implode('", "', $holiday).'"]';
		// $holiday = array_merge($holiday1, $holiday2);
		$holiday = $holiday1 + $holiday2;
		return response()->json($holiday);
		// return response($holiday)->header('Content-Type', 'text/plain');
		// print_r ($holiday2);
	}

	public function yearworkinghour1(Request $request)
	{
		$valid = TRUE;

		$po = WorkingHour::groupBy('year')->select('year')->get();

		foreach ($po as $k1) {
			if($k1->year == \Carbon\Carbon::parse($request->effective_date_start)->format('Y')) {
				$valid = FALSE;
				// exit();
			}
		}

		return response()->json([
			'year1' => \Carbon\Carbon::parse($request->effective_date_start)->format('Y'),
			'valid' => $valid
		]);
	}

	public function yearworkinghour2(Request $request)
	{
		$valid = TRUE;

		$po = WorkingHour::groupBy('year')->select('year')->get();

		foreach ($po as $k2) {
			if($k2->year == \Carbon\Carbon::parse($request->effective_date_end)->format('Y')) {
				$valid = FALSE;
				// exit();
			}
		}

		return response()->json([
			'year2' => \Carbon\Carbon::parse($request->effective_date_end)->format('Y'),
			'valid' => $valid
		]);
	}

	public function hcaldstart(Request $request)
	{
		$valid = true;
		// echo $request->date_start;
		$u = HolidayCalendar::all();
		foreach($u as $p) {
			$b = \Carbon\CarbonPeriod::create($p->date_start, '1 day', $p->date_end);
			// echo $p->date_start;
			// echo $p->date_end;
			foreach ($b as $key) {
				// echo $key;
				if($key->format('Y-m-d') == $request->date_start) {
					$valid = false;
				}
			}
		}
		return response()->json([
			'valid' => $valid,
		]);
	}

	public function hcaldend(Request $request)
	{
		$valid = true;
		// echo $request->date_end;
		$u = HolidayCalendar::all();
		foreach($u as $p) {
			$b = \Carbon\CarbonPeriod::create($p->date_start, '1 day', $p->date_end);
			// echo $p->date_start;
			// echo $p->date_end;
			foreach ($b as $key) {
				// echo $key;
				if($key->format('Y-m-d') == $request->date_end) {
					$valid = false;
				}
			}
		}
		return response()->json([
			'valid' => $valid,
		]);
	}


















}
