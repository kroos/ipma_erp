<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportLogistic;

use Illuminate\Http\Request;

use Session;

class ServiceReportLogisticController extends Controller
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

	public function show(ICSServiceReportLogistic $srLogistic)
	{
	//
	}

	public function edit(ICSServiceReportLogistic $srLogistic)
	{
	}

	public function update(Request $request, ICSServiceReportLogistic $srLogistic)
	{
	//
	}

	public function destroy(ICSServiceReportLogistic $srLogistic)
	{
		ICSServiceReportLogistic::destroy($srLogistic->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
