<?php

namespace App\Http\Controllers\Administrative\HumanResource\HRSettings;

use App\Http\Controllers\Controller;

// load model
use App\Model\HolidayCalendar;

use Illuminate\Http\Request;
use App\Http\Requests\HolidayCalendarRequest;

use \Carbon\Carbon;

use Session;

class HolidayCalendarController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('generalAndAdministrative.hr.hrsettings.index');
	}

	public function create()
	{
		return view('holidaycalendar.create');
	}

	public function store(HolidayCalendarRequest $request)
	{
		HolidayCalendar::create($request->except(['_token']));
		Session::flash('flash_message', 'Data successfully added!');
		return redirect( route('hrSettings.index') );
	}

	public function show(HolidayCalendar $holidayCalendar)
	{
	//
	}

	public function edit( HolidayCalendar $holidayCalendar )
	{
		return view('holidaycalendar.edit', compact(['holidayCalendar']));
	}

	public function update(HolidayCalendarRequest $request, HolidayCalendar $holidayCalendar)
	{
		HolidayCalendar::where('id', $holidayCalendar->id)->update($request->except(['_token', '_method']));
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('hrSettings.index') );
	}

	public function destroy(HolidayCalendar $holidayCalendar)
	{
		HolidayCalendar::destroy($holidayCalendar->id);
        return response()->json([
                                    'message' => 'Data deleted',
                                    'status' => 'success'
                                ]);
	}
}
