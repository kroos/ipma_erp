<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;

use Illuminate\Http\Request;

use Session;

class ServiceReportController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('marketingAndBusinessDevelopment.customerservice.ics.index');
	}

	public function create()
	{
		return view('marketingAndBusinessDevelopment.customerservice.ics.create');
	}

	public function store(Request $request)
	{
		print_r($request->all());
		$sr = \Auth::user()->belongtostaff->hasmanyservicereport()->create(
			array_add($request->only(['date', 'charge_id', 'customer_id', 'inform_by']), 'active', 1)
		);
		$sr->hasmanycomplaint()->create( $request->only(['complaint', 'complaint_by']) );
		$sr->hasmanyserial()->create( $request->only(['serial']) );
		// $sr->hasmanyattendees()->create( $request->only('sr') );
		foreach($request->sr as $key => $val) {
			$sr->hasmanyattendees()->create( ['attended_by' => $val['attended_by']] );
		}
		Session::flash('flash_message', 'Data successfully stored!');
		return redirect( route('serviceReport.index') );
	}

	public function show(ICSServiceReport $serviceReport)
	{
	//
	}

	public function edit(ICSServiceReport $serviceReport)
	{
		return view('marketingAndBusinessDevelopment.customerservice.ics.edit', compact(['serviceReport']));
	}

	public function update(Request $request, ICSServiceReport $serviceReport)
	{
	//
	}

	public function destroy(ICSServiceReport $serviceReport)
	{
	//
	}
}
