<?php

namespace App\Http\Controllers\Administrative\HumanResource\HRSettings;

use App\Http\Controllers\Controller;

// load model
use App\Model\HRSettings3Days;

use Illuminate\Http\Request;

use \Carbon\Carbon;

use Session;

class Setting3DaysCheckingController extends Controller
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

	}

	public function store(Request $request)
	{

	}

	public function show(HRSettings3Days $setting3DaysChecking)
	{

	}

	public function edit( HRSettings3Days $setting3DaysChecking )
	{

	}

	public function update(Request $request, HRSettings3Days $setting3DaysChecking)
	{
		print_r($request->all());
		// die();
		HRSettings3Days::where('id', $setting3DaysChecking->id)->update($request->except(['_token', '_method']));
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('hrSettings.index') );
	}

	public function destroy(HRSettings3Days $setting3DaysChecking)
	{

	}
}
