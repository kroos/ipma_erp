<?php

namespace App\Http\Controllers\AjaxRemote;

use App\Http\Controllers\Controller;

use App\Model\WorkingHour;
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
}
