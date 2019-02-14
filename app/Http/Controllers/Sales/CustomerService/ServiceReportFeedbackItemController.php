<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSServiceReportFeedItem;

use Illuminate\Http\Request;

use Session;

class ServiceReportFeedbackItemController extends Controller
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

	public function show(ICSServiceReportFeedItem $srFeedItem)
	{
	//
	}

	public function edit(ICSServiceReportFeedItem $srFeedItem)
	{
	}

	public function update(Request $request, ICSServiceReportFeedItem $srFeedItem)
	{
	//
	}

	public function destroy(ICSServiceReportFeedItem $srFeedItem)
	{
		ICSServiceReportFeedItem::destroy($srFeedItem->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
