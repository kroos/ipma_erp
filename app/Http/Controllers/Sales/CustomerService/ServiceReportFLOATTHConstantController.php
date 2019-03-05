<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSFloatthConstant;

use Illuminate\Http\Request;

use Session;

class ServiceReportFLOATTHConstantController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('marketingAndBusinessDevelopment.customerservice.ics.settings.index');
	}

	public function create()
	{
	}

	public function store(Request $request)
	{
	}

	public function show(ICSFloatthConstant $srConstant)
	{
	//
	}

	public function edit(ICSFloatthConstant $srConstant)
	{
		return view('marketingAndBusinessDevelopment.customerservice.ics.settings.edit', compact(['srConstant']));
	}

	public function update(Request $request, ICSFloatthConstant $srConstant)
	{
		print_r($request->all());
		ICSFloatthConstant::where('id', $srConstant->id)->update($request->except(['_method', '_token']));
		Session::flash('flash_message', 'Data successfully updated!');
		return redirect( route('srConstant.index') );
	}

	public function destroy(ICSFloatthConstant $srConstant)
	{
		ICSFloatthConstant::destroy($srConstant->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
