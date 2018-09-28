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

		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staffManagement.index') );
	}

	public function createHR()
	{
		return view('generalAndAdministrative.hr.staffmanagement.staffHR.createHR');
	}

	public function storeHR(Request $request)
	{
		
	}
	
	public function show(Staff $staffHR)
	{
		return view( 'generalAndAdministrative.hr.staffmanagement.staffHR.show', compact(['staffHR']) );
	}

	public function edit(Staff $staffHR)
	{
		return view('generalAndAdministrative.hr.staffmanagement.staffHR.edit', compact(['staffHR']));
	}

	public function editHR(Staff $staffHR)
	{
		return view('generalAndAdministrative.hr.staffmanagement.staffHR.editHR', compact(['staffHR']));
	}

	public function update(Request $request, Staff $staffHR)
	{
		if( !is_null($request->file('image')) ) {
			$filename = $request->file('image')->store('public/images/profiles');

			$ass1 = explode('/', $filename);
			$ass2 = array_except($ass1, ['0']);
			$image = implode('/', $ass2);

			$imag = Image::make(storage_path('app/'.$filename));

			// resize the image to a height of 400 and constrain aspect ratio (auto width)
			$imag->resize(null, 400, function ($constraint) {
				$constraint->aspectRatio();
			});

			$imag->save();

			$r = $staffHR->update( array_add($request->except(['_method', '_token', 'image']), 'image', $image) );
		} else {
			$r = $staffHR->update( $request->except(['_method', '_token', 'image']) );
		}

		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staffManagement.index') );
	}

	public function updateHR(Request $request, Staff $staffHR)
	{
		print_r($request->all());
		echo '<br />';
		print_r ($request->except(['_method', '_token']));
		echo '<br />';
	}

	public function destroy(Staff $staffHR)
	{
	}
}
