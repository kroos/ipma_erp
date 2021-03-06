<?php

namespace App\Http\Controllers\Profile;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use App\Model\StaffLeaveBackup;

use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffLeaveBackupRequest;

// for manipulating image
// http://image.intervention.io/
// use Intervention\Image\Facades\Image as Image;       <-- ajaran sesat depa... hareeyyyyy!!
use Intervention\Image\ImageManagerStatic as Image;

use Session;

class StaffLeaveBackupController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('userown', ['only' => ['show', 'edit', 'update']]);
	}
	
	public function index()
	{
		return view('staffLeaveBackup.index');
	}

	public function create()
	{
	}

	public function store(StaffLeaveBackupRequest $request)
	{
	}

	public function show(StaffLeaveBackup $staffLeaveBackup)
	{
	}

	public function edit(StaffLeaveBackup $staffLeaveBackup)
	{
	}

	public function update(StaffLeaveBackupRequest $request, StaffLeaveBackup $staffLeaveBackup)
	{
		// dd($request->all() );
		$n = \Auth::user()->belongtostaff->hasmanystaffleavebackup()->where('id', $request->id)->update([
			'acknowledge' => 1
		]);
		return response()->json([
			'status' => 'success',
			'message' => 'The applicant appreciate it very much. Thank you.'
		]);
	}

	public function destroy(StaffLeaveBackup $staffLeaveBackup)
	{
	}
}
