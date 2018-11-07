<?php

namespace App\Http\Controllers\Administrative\HumanResource\StaffManagement;

use App\Http\Controllers\Controller;

// load model
use App\Model\Leave;
use App\Model\StaffTCMS;
use App\Model\HolidayCalendar;
use App\Model\StaffLeave;

use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Http\Request;

class StaffAvailabilityController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('generalAndAdministrative.hr.staffmanagement.availability.index');
	}

	public function create()
	{
	//
	}

	public function store(Request $request)
	{
	//
	}

	public function show(Leave $leave)
	{
	//
	}

	public function edit(Leave $leave)
	{
	//
	}

	public function update(Request $request, Leave $leave)
	{
	//
	}

	public function destroy(Leave $leave)
	{
	//
	}
}
