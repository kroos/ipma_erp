<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportPart;

use Illuminate\Http\Request;

use Session;

class ServiceReportPartAccessoryController extends Controller
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

	public function show(ICSServiceReportPart $srPart)
	{
	//
	}

	public function edit(ICSServiceReportPart $srPart)
	{
	}

	public function update(Request $request, ICSServiceReportPart $srPart)
	{
	//
	}

	public function destroy(ICSServiceReportPart $srPart)
	{
		ICSServiceReportPart::destroy($srPart->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
