<?php

namespace App\Http\Controllers\Administrative\HumanResource\HRSettings;

use App\Http\Controllers\Controller;

// load model
use App\Model\HolidayCalendar;

use Illuminate\Http\Request;

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
		return view('workinghour.create');
	}

	public function store(Request $request)
	{
		print_r( $request->all() );
die();
        Session::flash('flash_message', 'Data successfully edited!');
        return redirect( route('workingHours.index') );
	}

	public function show(HolidayCalendar $holidayCalendar)
	{
	//
	}

	public function edit(HolidayCalendar $holidayCalendar)
	{
	//
	}

	public function update(Request $request, HolidayCalendar $holidayCalendar)
	{
	//
	}

	public function destroy(HolidayCalendar $holidayCalendar)
	{
	//
	}
}
