<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportFeedCall;

use Illuminate\Http\Request;

// load request validation
use App\Http\Requests\ICSSRFeedbackCallRequest;

use Session;

class ServiceReportFeedbackCallController extends Controller
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

	public function store(ICSSRFeedbackCallRequest $request)
	{
		// var_dump($request->all());
		$r = ICSServiceReportFeedCall::create($request->except(['_token']));
		if($r) {
			return response()->json([
				'message' => 'Data Saved',
				'status' => 'success'
			]);
		}
	}

	public function show(ICSServiceReportFeedCall $srAddCharge)
	{
	//
	}

	public function edit(ICSServiceReportFeedCall $srAddCharge)
	{
	}

	public function update(Request $request, ICSServiceReportFeedCall $srAddCharge)
	{
	//
	}

	public function destroy(ICSServiceReportFeedCall $srAddCharge)
	{
		ICSServiceReportFeedCall::destroy($srAddCharge->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
