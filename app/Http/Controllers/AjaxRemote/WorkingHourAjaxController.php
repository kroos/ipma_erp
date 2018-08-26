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

		if($userposition->id == 72){
			$time = \App\Model\WorkingHour::where('year', date('Y'))->where('category', 7);
		} else {
			$time = \App\Model\WorkingHour::where('year', date('Y'))->whereRaw('"'.$request->date.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
		}
		return response()->json([
			'start_am' => $time->first()->time_start_am,
			'end_am' => $time->first()->time_end_am,
			'start_pm' => $time->first()->time_start_pm,
			'end_pm' => $time->first()->time_end_pm,
		]);
	}
}
