<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportAdditionalCharge;

use Illuminate\Http\Request;

use Session;

class ServiceReportAdditionalChargesController extends Controller
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

	public function show(ICSServiceReportAdditionalCharge $srAddCharge)
	{
	//
	}

	public function edit(ICSServiceReportAdditionalCharge $srAddCharge)
	{
	}

	public function update(Request $request, ICSServiceReportAdditionalCharge $srAddCharge)
	{
	//
	}

	public function destroy(ICSServiceReportAdditionalCharge $srAddCharge)
	{
		ICSServiceReportAdditionalCharge::destroy($srAddCharge->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
