<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportSerial;

use Illuminate\Http\Request;

use Session;

class ServiceReportSerialController extends Controller
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

	public function show(ICSServiceReportSerial $srSerial)
	{
	//
	}

	public function edit(ICSServiceReportSerial $srSerial)
	{
	}

	public function update(Request $request, ICSServiceReportSerial $srSerial)
	{
	//
	}

	public function destroy(ICSServiceReportSerial $srSerial)
	{
		ICSServiceReportSerial::destroy($srSerial->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
