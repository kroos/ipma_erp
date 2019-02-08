<?php

namespace App\Http\Controllers\Administrative\HumanResource\HRSettings;

use App\Http\Controllers\Controller;

// load model
use App\Model\HRSettingsDoubleDate;

use Illuminate\Http\Request;

use \Carbon\Carbon;

use Session;

class SettingDoubleDateController extends Controller
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
		Session::flash('flash_message', 'Data successfully added!');
		return redirect( route('hrSettings.index') );
	}

	public function show(HRSettingsDoubleDate $settingDoubleDate)
	{

	}

	public function edit( HRSettingsDoubleDate $settingDoubleDate )
	{

	}

	public function update(Request $request, HRSettingsDoubleDate $settingDoubleDate)
	{
		// print_r($request->all());
		HRSettingsDoubleDate::where('id', $settingDoubleDate->id)->update($request->except(['_token', '_method']));
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('hrSettings.index') );
	}

	public function destroy(HRSettingsDoubleDate $settingDoubleDate)
	{

	}
}
