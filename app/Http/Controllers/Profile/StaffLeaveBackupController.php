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
		$this->middleware('userown', ['only' => ['show', 'edit', 'update']]);
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

	public function show(StaffLeaveBackup $staff)
	{
	}

	public function edit(StaffLeaveBackup $staff)
	{
	}

	public function update(StaffLeaveBackupRequest $request, StaffLeaveBackup $staff)
	{
	}

	public function destroy(StaffLeaveBackup $staff)
	{
	}
}
