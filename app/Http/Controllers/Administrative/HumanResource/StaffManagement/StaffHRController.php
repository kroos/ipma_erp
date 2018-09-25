<?php

namespace App\Http\Controllers\Administrative\HumanResource\StaffManagement;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use App\Model\Staff;

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
	}
	
	public function show(Staff $staff)
	{
	}
	
	public function edit(Staff $staff)
	{
		return view('generalAndAdministrative.hr.staffmanagement.staffHR.edit', compact(['staff']));
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
