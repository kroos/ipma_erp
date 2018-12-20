<?php

namespace App\Http\Controllers\Administrative\HumanResource\StaffManagement;

// to link back from controller original
use App\Http\Controllers\Controller;

// load this to use DB
use Illuminate\Support\Facades\DB;

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
		$st1 = DB::table('staffs')->
				leftJoin('staff_positions', 'staff_positions.staff_id', '=', 'staffs.id')->
				leftJoin('positions', 'staff_positions.position_id', '=', 'positions.id')->
				leftJoin('departments', 'positions.department_id', '=', 'departments.id')->
				leftJoin('locations', 'staffs.location_id', '=', 'locations.id')->
				leftJoin('logins', 'logins.staff_id', '=', 'staffs.id')->
				select('staffs.id', 'logins.username', 'staffs.name', 'departments.department', 'locations.location', 'positions.category_id', 'positions.id as pos_id')->
				whereNotIn('staffs.id', [191, 192])->
				where([
					['positions.category_id', 1],
					['staffs.active', 1],
					['staff_positions.main', 1],
					['logins.active', 1]
				])->
				orderBy('staffs.id', 'asc')->
				get();
		
		$st2 = DB::table('staffs')->
				leftJoin('staff_positions', 'staff_positions.staff_id', '=', 'staffs.id')->
				leftJoin('positions', 'staff_positions.position_id', '=', 'positions.id')->
				leftJoin('departments', 'positions.department_id', '=', 'departments.id')->
				leftJoin('locations', 'staffs.location_id', '=', 'locations.id')->
				leftJoin('logins', 'logins.staff_id', '=', 'staffs.id')->
				select('staffs.id', 'logins.username', 'staffs.name', 'departments.department', 'locations.location', 'positions.category_id', 'positions.id as pos_id')->
				where([
					['positions.category_id', 2],
					['staffs.active', 1],
					['staff_positions.main', 1],
					['logins.active', 1]
				])->
				orderBy('staffs.id', 'asc')->
				get();

		return view('generalAndAdministrative.hr.staffmanagement.attendance.index', compact(['st1', 'st2']));
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
