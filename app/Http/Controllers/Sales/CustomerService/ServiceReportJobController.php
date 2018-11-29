<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportJob;

use Illuminate\Http\Request;

use Session;

class ServiceReportJobController extends Controller
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

	public function show(ICSServiceReportJob $srJob)
	{
	//
	}

	public function edit(ICSServiceReportJob $srJob)
	{
	}

	public function update(Request $request, ICSServiceReportJob $srJob)
	{
	//
	}

	public function destroy(ICSServiceReportJob $srJob)
	{
		$srJob->hasmanysrjobdetail()->delete();
		// $srJob->destroy();
		ICSServiceReportJob::destroy($srJob->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
