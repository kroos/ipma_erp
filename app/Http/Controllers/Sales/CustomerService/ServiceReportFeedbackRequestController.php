<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportFeedRequest;

use Illuminate\Http\Request;

use Session;

class ServiceReportFeedbackRequestController extends Controller
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

	public function show(ICSServiceReportFeedRequest $srFeedReq)
	{
	//
	}

	public function edit(ICSServiceReportFeedRequest $srFeedReq)
	{
	}

	public function update(Request $request, ICSServiceReportFeedRequest $srFeedReq)
	{
	//
	}

	public function destroy(ICSServiceReportFeedRequest $srFeedReq)
	{
		ICSServiceReportFeedRequest::destroy($srFeedReq->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
