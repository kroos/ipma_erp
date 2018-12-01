<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportFeedProblem;

use Illuminate\Http\Request;

use Session;

class ServiceReportFeedbackProblemController extends Controller
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

	public function show(ICSServiceReportFeedProblem $srFeedProb)
	{
	//
	}

	public function edit(ICSServiceReportFeedProblem $srFeedProb)
	{
	}

	public function update(Request $request, ICSServiceReportFeedProblem $srFeedProb)
	{
	//
	}

	public function destroy(ICSServiceReportFeedProblem $srFeedProb)
	{
		ICSServiceReportFeedProblem::destroy($srFeedProb->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
