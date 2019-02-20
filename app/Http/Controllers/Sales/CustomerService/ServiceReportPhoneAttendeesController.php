<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportAttendeesPhone;

use Illuminate\Http\Request;

use Session;

class ServiceReportPhoneAttendeesController extends Controller
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

	public function show(ICSServiceReportAttendeesPhone $srAttendPhone)
	{
	//
	}

	public function edit(ICSServiceReportAttendeesPhone $srAttendPhone)
	{
	}

	public function update(Request $request, ICSServiceReportAttendeesPhone $srAttendPhone)
	{
	//
	}

	public function destroy(ICSServiceReportAttendeesPhone $srAttendPhone)
	{
		ICSServiceReportAttendeesPhone::destroy($srAttendPhone->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
