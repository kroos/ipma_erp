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

	public function gender()
	{
		$er = \App\Model\Gender::all();
		// https://select2.org/data-sources/formats
		foreach ($er as $key) {
			$gen['results'][] = [
					'id' => $key->id,
					'text' => $key->gender,
			];
			// $gen['pagination'] = ['more' => true];
		}
		return response()->json( $gen );
	}

	public function statusstaff()
	{
		$er = \App\Model\Status::where('id', '<>', 1)->get();
		// https://select2.org/data-sources/formats
		foreach ($er as $key) {
			$stat['results'][] = [
					'id' => $key->id,
					'text' => $key->status,
					'code' => $key->code,
			];
			// $stat['pagination'] = ['more' => true];
		}
		return response()->json( $stat );
	}

	public function location()
	{
		$loc = \App\Model\Location::all();
		// https://select2.org/data-sources/formats
		foreach ($loc as $key) {
			$loc1['results'][] = [
					'id' => $key->id,
					'text' => $key->location,
			];
			// $loc1['pagination'] = ['more' => true];
		}
		return response()->json( $loc1 );
	}

	public function division()
	{
		$divs = \App\Model\Division::all();
		// https://select2.org/data-sources/formats
		foreach ($divs as $key) {
			$div['results'][] = [
				'id' => $key->id,
				'text' => $key->division,
			];
			// $div['pagination'] = ['more' => true];
		}
		return response()->json( $div );
	}

	public function department(Request $request)
	{
		$depts = \App\Model\Department::where('division_id', $request->division_id)->get();
		// https://select2.org/data-sources/formats
		foreach ($depts as $key) {
			// $dept['results'][] = [
			// 		'id' => $key->id,
			// 		'text' => $key->department,
			// 		'division_id' => $key->division_id,
			// ];
			// $dept['pagination'] = ['more' => true];
			$dept[$key->id] = $key->department;
		}
		return response()->json( $dept );
	}

	public function position(Request $request)
	{
		$poss = \App\Model\Position::where('department_id', $request->department_id)->get();
		// https://select2.org/data-sources/formats
		foreach ($poss as $key) {
			// $pos['results'][] = [
			// 		'id' => $key->id,
			// 		'text' => $key->position,
			// 		'department_id' => $key->department_id,
			// ];
			// $pos['pagination'] = ['more' => true];
			$pos[$key->id] = $key->position;
		}
		return response()->json( $pos );
	}

	public function loginuser(Request $request)
	{
		$valid = true;
		$log = \App\Model\Login::all();
		foreach($log as $k) {
			if($k->username == $request->username) {
				$valid = false;
			}
		}
		return response()->json([
			'valid' => $valid,
		]);
	}

	public function dts(Request $request)
	{
		$date1 = \Carbon\Carbon::parse($request->dts)->format('Y-m-d');
		$date2 = \Carbon\Carbon::parse($request->dte)->format('Y-m-d');

		$period = \Carbon\CarbonPeriod::create($date1, '1 days', $date2);

		// count all date
		// echo $period->count().' total hari<br />';

		// kira cuti ahad
		$cuti = [];
		$nodays = \App\Model\HolidayCalendar::where('date_start', '>=', $date1 )->where( 'date_end', '<=', $date2 )->get();
		// echo $nodays.' json for the whole year<br />';
		foreach ($nodays as $uy) {
			// take cuti date from database
			$perC = \Carbon\CarbonPeriod::create($uy->date_start, '1 days', $uy->date_end);
			// echo $perC->count().' hari cuti dari '.$date1.' <=> '.$date2.'<br />';
			foreach ($perC as $aha) {
				$adaahaddlmni = \Carbon\Carbon::parse( $aha, 'Y-m-d' )->dayOfWeek;
				if($adaahaddlmni != 0) {
					// echo $aha.' no ahad in cuti<br />';
					$cuti[] = $aha;
				}
			}
		}
		// echo count($cuti).' bilangan hari cuti ahad<br />';

		// substract all sundays
		$sundi = [];
		foreach ($period as $op) {
			$sund = \Carbon\Carbon::parse( $op )->dayOfWeek;
			if($sund != 0) {
				// echo $op.' bukan hari ahad<br />';
				$sundi[] = $op;
			}
		}
		// echo count($sundi).' bilangan hari bukan hari ahad dalam range<br />';

		if($request->leave_type == 2) {
			$haricuti = 0.5;
		} else {
			$haricuti = count($sundi) - count($cuti);
		}

		// echo $haricuti.' applied leave for this year<br />';

		return response()->json([
			'period' => $haricuti
		]);
	}

	public function dte(Request $request)
	{
		$date1 = \Carbon\Carbon::parse($request->dts)->format('Y-m-d');
		$date2 = \Carbon\Carbon::parse($request->dte)->format('Y-m-d');

		$period = \Carbon\CarbonPeriod::create($date1, '1 days', $date2);

		// count all date
		// echo $period->count().' total hari<br />';

		// kira cuti ahad
		$cuti = [];
		$nodays = \App\Model\HolidayCalendar::where('date_start', '>=', $date1 )->where( 'date_end', '<=', $date2 )->get();
		// echo $nodays.' json for the whole year<br />';
		foreach ($nodays as $uy) {
			// take cuti date from database
			$perC = \Carbon\CarbonPeriod::create($uy->date_start, '1 days', $uy->date_end);
			// echo $perC->count().' hari cuti dari '.$date1.' <=> '.$date2.'<br />';
			foreach ($perC as $aha) {
				$adaahaddlmni = \Carbon\Carbon::parse( $aha, 'Y-m-d' )->dayOfWeek;
				if($adaahaddlmni != 0) {
					// echo $aha.' no ahad in cuti<br />';
					$cuti[] = $aha;
				}
			}
		}
		// echo count($cuti).' bilangan hari cuti ahad<br />';

		// substract all sundays
		$sundi = [];
		foreach ($period as $op) {
			$sund = \Carbon\Carbon::parse( $op )->dayOfWeek;
			if($sund != 0) {
				// echo $op.' bukan hari ahad<br />';
				$sundi[] = $op;
			}
		}
		// echo count($sundi).' bilangan hari bukan hari ahad dalam range<br />';

		if($request->leave_type == 2) {
			$haricuti = 0.5;
		} else {
			if($request->leave_type == 1) {
				$haricuti = 1;
			} else {
				$haricuti = count($sundi) - count($cuti);
			}
		}
		// echo $haricuti.' applied leave for this year<br />';

		return response()->json([
			'period' => $haricuti
		]);
	}

	public function tftimeperiod(Request $request)
	{
		$tim1 = \Carbon\Carbon::create($request->date_time_start.' '.$request->time_start, 'Y-m-d h:m A');
		$tim2 = \Carbon\Carbon::create($request->date_time_start.' '.$request->time_end, 'Y-m-d h:m A');
		// echo $tim1.' date time start<br />';
		// echo $tim2.' date time end<br />';

		// var_dump($tim1->gte($tim2));

		if ( $tim1->gte($tim2) ) { // time start less than time end
			Session::flash('flash_message', 'Masa bagi permohonon Time Off tidak dapat diproses ('.\Carbon\Carbon::parse($request->date_time_start.' '.$request->time_start)->format('D, j F Y h:i A').' hingga '.\Carbon\Carbon::parse($request->date_time_start.' '.$request->time_end)->format('D, j F Y h:i A').') . Sila ambil masa yang lain.');
			return redirect()->back()->withInput();
		}

		// period time
		$userposition = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
		$dt = \Carbon\Carbon::parse($request->date_time_start);

		if( $userposition->id == 72 && $dt->dayOfWeek != 5 ) {	// checking for friday

			$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
		} else {

			if ( $userposition->id == 72 && $dt->dayOfWeek == 5 ) {	// checking for friday

				$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
			} else {

				if( $userposition->id != 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
					// normal
					$time = \App\Model\WorkingHour::where('year', $dt->year)->whereRaw('"'.$request->date_time_start.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
				} else {
					if( $userposition->id != 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
						$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 3)->whereRaw('"'.$request->date_time_start.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
					}
				}
			}
		}

		$times = \Carbon\Carbon::parse($request->date_time_start.' '.$request->time_start)->format('H:i:s');
		$timee = \Carbon\Carbon::parse($request->date_time_start.' '.$request->time_end)->format('H:i:s');
		$timep = \Carbon\CarbonPeriod::create($request->date_time_start.' '.$times, '1 minutes', $request->date_time_start.' '.$timee, \Carbon\CarbonPeriod::EXCLUDE_START_DATE);
		// echo $times.' time start<br />';
		// echo $timee.' time end<br />';

		// echo $timep->count().' tempoh minit masa keluar sblm tolak recess<br />';

		// echo 'start_am => '.$time->first()->time_start_am.' time start am<br />';
		// echo 'end_am => '.$time->first()->time_end_am.' time end am<br />';
		// echo 'start_pm => '.$time->first()->time_start_pm.' time start pm<br />';
		// echo 'end_pm => '.$time->first()->time_end_pm.' time end pm<br />';

		$timefull = \Carbon\CarbonPeriod::create($request->date_time_start.' '.$time->first()->time_start_am, '1 minutes', $request->date_time_start.' '.$time->first()->time_end_pm, \Carbon\CarbonPeriod::EXCLUDE_START_DATE);
		$timeamwh = \Carbon\CarbonPeriod::create($request->date_time_start.' '.$time->first()->time_start_am, '1 minutes', $request->date_time_start.' '.$time->first()->time_end_am, \Carbon\CarbonPeriod::EXCLUDE_START_DATE);
		$timepmwh = \Carbon\CarbonPeriod::create($request->date_time_start.' '.$time->first()->time_start_pm, '1 minutes', $request->date_time_start.' '.$time->first()->time_end_pm, \Carbon\CarbonPeriod::EXCLUDE_START_DATE);

		// echo $timefull->count().' time full<br />';
		// echo $timeamwh->count().' timeamwh<br />';
		// echo $timepmwh->count().' timepmwh<br />';

		// foreach($timep as $tpout) {
		// 	echo $tpout.' time off<br />';
		// }

		foreach($timefull as $tf) {
			// echo $tf.' minutes for time full<br />';
			foreach ($timeamwh as $tamwh) {
				if ($tf == $tamwh) {
					// echo $tamwh.' minutes for am working hours<br />';
					$timecomb[] = $tamwh;
				}
			}
			foreach ($timepmwh as $tpmwh) {
				if($tf == $tpmwh) {
					// echo $tpmwh.' minutes for pm working hours<br />';
					$timecomb[] = $tpmwh;
				}
			}
		}

		$i = 0;
		// we already have all the working minutes synch, so..
		foreach ($timecomb as $key) {
			// echo $key.' working minutes combin<br />';
			foreach($timep as $tpout) {
				if($tpout == $key) {
					$timing = $i++; // satu saja.. jgn 2 sekali
					// echo $tpout.' time off<br />';
					// echo $i++.' minutes<br />';
				}
			}
		}

		// convert minuts to hour and minutes
		$hour = floor($i/60);
		$minute = ($i % 60);
		$hours1 = $hour.' jam '.$minute.' minit';
		// echo $hour.' jam '.$minute.' minit<br />';

		return response()->json([
			'period' => $i,
			'hours' => $hours1,
		]);
	}










}
