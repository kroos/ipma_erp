<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportDiscount;

use Illuminate\Http\Request;

use Session;

class ServiceReportDiscountController extends Controller
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

	public function show(ICSServiceReportDiscount $srDiscount)
	{
	//
	}

	public function edit(ICSServiceReportDiscount $srDiscount)
	{
	}

	public function update(Request $request, ICSServiceReportDiscount $srDiscount)
	{
	//
	}

	public function destroy(ICSServiceReportDiscount $srDiscount)
	{
		ICSServiceReportDiscount::destroy($srDiscount->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
