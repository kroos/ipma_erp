<?php

namespace App\Http\Controllers\Administrative\HumanResource\StaffManagement;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use App\Model\Staff;
use App\Model\StaffAnnualMCLeave;
use App\Model\StaffPosition;
use App\Model\Position;

use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Http\Request;

class StaffDisciplineController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('generalAndAdministrative.hr.staffmanagement.attendance.index');
	}

	public function create()
	{
	//
	}

	public function store(Request $request)
	{
	//
	}

	public function show(Staff $staffDis)
	{
	//
	}

	public function edit(Staff $staffDis)
	{
	//
	}

	public function update(Request $request, Staff $staffDis)
	{
	//
	}

	public function destroy(Staff $staffDis)
	{
	//
	}
}
