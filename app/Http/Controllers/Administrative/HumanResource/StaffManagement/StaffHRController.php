<?php

namespace App\Http\Controllers\Administrative\HumanResource\StaffManagement;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use App\Model\Staff;
use App\Model\StaffAnnualMCLeave;
use App\Model\Login;
use App\Model\StaffPosition;
use App\Model\Position;

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
		$u = Staff::create( array_add($request->only(['name', 'status_id', 'gender_id', 'join_at', 'dob', 'location_id', 'leave_need_backup']), 'active', 1) );

		if(!empty($request->file('image'))) {
			$filename = $request->file('image')->store('public/images/profiles');

			$ass1 = explode('/', $filename);
			$ass2 = array_except($ass1, ['0']);
			$image = implode('/', $ass2);

			// dd($image);

			$imag = Image::make(storage_path('app/'.$filename));

			// resize the image to a height of 400 and constrain aspect ratio (auto width)
			$imag->resize(null, 400, function ($constraint) {
				$constraint->aspectRatio();
			});

			$imag->save();
			// dd( array_add($request->except(['image']), 'image', $filename) );

			$u->update(['image' => $image]);
		}

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

	public function show(Staff $staffHR)
	{
		return view( 'generalAndAdministrative.hr.staffmanagement.staffHR.show', compact(['staffHR']) );
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// custom show for report
	public function showReport(Staff $staffHR)
	{
		return view( 'generalAndAdministrative.hr.staffmanagement.staffHR.showReport', compact(['staffHR']) );
	}

	public function ddestroy(Staff $staffHR, Request $request)
	{
		// echo $request->id;
		// $rt = $staffHR->belongtomanydiscipline()->detach($request->id);
		$rt = \App\Model\StaffDiscipline::destroy($request->id);
		// dd($rt);
		if ($rt) {
			return response()->json([
				'message' => 'Data deleted',
				'status' => 'success'
			]);
		} else {
			return response()->json([
				'message' => $request->id,
				'status' => 'error'
			]);
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function edit(Staff $staffHR)
	{
		return view('generalAndAdministrative.hr.staffmanagement.staffHR.edit', compact(['staffHR']));
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
///////////////////////////////////////////////////////////////////////////////////////////////////
	public function editHR(Staff $staffHR)
	{
		return view('generalAndAdministrative.hr.staffmanagement.staffHR.editHR', compact(['staffHR']));
	}

	public function updateHR(Request $request, Staff $staffHR)
	{
		// buat kerja loqlaq, delete all then insert all from input
		// use detach then attach
		$staffHR->belongtomanyposition()->detach();
		foreach( $request->staff as $key => $val) {
			if (!isset($val['main'])) {
				$val['main'] = NULL;
			}
			$staffHR->belongtomanyposition()->attach( $val['position_id'], ['main' => $val['main']] );
			// echo $val['main'].'<br />';
		}

		$staffHR->update( $request->only(['leave_need_backup', 'location_id']) );
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staffManagement.index') );
	}

	public function disableHR(Staff $staffHR)
	{
		$staffHR->hasmanylogin()->where('active', 1)->update(['active' => 0]);
		$staffHR->update(['active' => 0]);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}

	public function promoteHR(Staff $staffHR)
	{
		return view('generalAndAdministrative.hr.staffmanagement.staffHR.promoteHR', compact(['staffHR']));
	}

	public function promoteupdateHR(Request $request, Staff $staffHR)
	{
		// 1. get the the id
		$id = $staffHR->hasmanylogin()->where('active', 1)->first()->id;

		// 2. disable old login
		$staffHR->hasmanylogin()->where('id', $id)->update(['active' => 0]);
		$pass = $staffHR->hasmanylogin()->where('id', $id)->first()->password;

		// 3. insert new Login
		$staffHR->hasmanylogin()->create([
			'username' => $request->username,
			'password' => $pass,
			'active' => 1
		]);

		// 4. change status at staff model
		$staffHR->update(['status_id' => 1]);
// die();
		// 5. update the staff_annual_MC_maternity_leave
		$staffHR->hasmanystaffannualmcleave()->where('year', date('Y'))->updateOrCreate(
			['year' => date('Y')],
			[
				'annual_leave' => $request->annual_leave,
				'annual_leave_balance' => $request->annual_leave,
				'medical_leave' => $request->medical_leave,
				'medical_leave_balance' => $request->medical_leave,
				'maternity_leave' => '60',
				'maternity_leave_balance' => '60',
			]
		);
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staffManagement.index') );
	}

///////////////////////////////////////////////////////////////////////////////////////////////////
	public function destroy(StaffPosition $staffHR)
	{
		\App\Model\StaffPosition::destroy($staffHR->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}

