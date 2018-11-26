<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportModel;

use Illuminate\Http\Request;

use Session;

class ServiceReportModelController extends Controller
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

	public function show(ICSServiceReportModel $srModel)
	{
	//
	}

	public function edit(ICSServiceReportModel $srModel)
	{
	}

	public function update(Request $request, ICSServiceReportModel $srModel)
	{
	//
	}

	public function destroy(ICSServiceReportModel $srModel)
	{
		ICSServiceReportModel::destroy($srModel->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
