<?php

namespace App\Http\Controllers\Administrative\HumanResource\StaffManagement;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use App\Model\Staff;
use App\Model\StaffAnnualMCLeave;
use App\Model\Login;
use App\Model\StaffPosition;

use Illuminate\Http\Request;

// load validation
// use App\Http\Requests\StaffProfileRequest;

// for manipulating image
// http://image.intervention.io/
// use Intervention\Image\Facades\Image as Image;       <-- ajaran sesat depa... hareeyyyyy!!
use Intervention\Image\ImageManagerStatic as Image;

use Session;

class StaffHRController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index()
	{
	
	}
	
	public function create()
	{
		return view('generalAndAdministrative.hr.staffmanagement.staffHR.create');
	}
	
	public function store(Request $request)
	{
		print_r ($request->all());
		// insert into 4 tables
		// staff, login, staff_annual_MC_maternity_leaves, staff_positions
// die();
		$u = Staff::create( array_add($request->only(['name', 'status_id', 'gender_id', 'join_at', 'dob', 'location_id']), 'active', 1 ) );
		$u->hasmanylogin()->create( array_add($request->only(['username', 'password']), 'active', 1) );
		$u->hasmanystaffannualmcleave()->create([
			'year' => date('Y'),
			'annual_leave' => 0,
			'annual_leave_adjustment' => 0,
			'annual_leave_balance' => 0,
			'medical_leave' => 0,
			'medical_leave_adjustment' => 0,
			'medical_leave_balance' => 0,
			'maternity_leave' => 0,
			'maternity_leave_balance' => 0
		]);
		$u->belongtomanyposition()->attach( $request->only(['position_id']), ['main' => 1] );
	}
	
	public function show(Staff $staffHR)
	{
		return view( 'generalAndAdministrative.hr.staffmanagement.staffHR.show', compact(['staffHR']) );
	}
	
	public function edit(Staff $staffHR)
	{
		return view('generalAndAdministrative.hr.staffmanagement.staffHR.edit', compact(['staffHR']));
	}
	
	public function update(Request $request, Staff $staff)
	{
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staffManagement.index') );
	}
	
	public function destroy(Staff $staff)
	{
	}
}
