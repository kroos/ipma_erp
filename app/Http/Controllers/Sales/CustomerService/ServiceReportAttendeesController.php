<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportSerial;
use App\Model\ICSServiceReportAttendees;

use Illuminate\Http\Request;

use Session;

class ServiceReportAttendeesController extends Controller
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

	public function show(ICSServiceReportAttendees $srAttend)
	{
	//
	}

	public function edit(ICSServiceReportAttendees $srAttend)
	{
	}

	public function update(Request $request, ICSServiceReportAttendees $srAttend)
	{
	//
	}

	public function destroy(ICSServiceReportAttendees $srAttend)
	{
		ICSServiceReportAttendees::destroy($srAttend->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
