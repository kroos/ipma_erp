<?php

namespace App\Http\Controllers\Profile;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use App\Model\StaffLeaveApproval;

use Illuminate\Http\Request;

// load validation
// use App\Http\Requests\StaffLeaveApprovalRequest;

// for manipulating image
// http://image.intervention.io/
// use Intervention\Image\Facades\Image as Image;       <-- ajaran sesat depa... hareeyyyyy!!
// use Intervention\Image\ImageManagerStatic as Image;

use Session;

class StaffLeaveApprovalController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('userown', ['only' => ['show', 'edit', 'update']]);
	}
	
	public function index()
	{
		return view('staffLeaveApproval.index');
	}

	public function create()
	{
	}

	public function store(Request $request)
	{
	}

	public function show(StaffLeaveApproval $staffLeaveApproval)
	{
	}

	public function edit(StaffLeaveApproval $staffLeaveApproval)
	{
	}

	public function update(Request $request, StaffLeaveApproval $staffLeaveApproval)
	{
		echo $staffLeaveApproval;
		dd($request->all() );

	}

	public function destroy(StaffLeaveApproval $staffLeaveApproval)
	{
	}
}
