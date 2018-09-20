<?php

namespace App\Http\Controllers\Administrative\HumanResource\HRSettings;

use App\Http\Controllers\Controller;

// load model
use App\Model\Leave;

use Illuminate\Http\Request;

class HRSettingsController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('generalAndAdministrative.hr.hrsettings.index');
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
