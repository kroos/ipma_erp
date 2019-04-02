<?php

namespace App\Http\Controllers\Sales\Costing;

use App\Http\Controllers\Controller;

// load model
use App\Model\QuotRemark;

use Illuminate\Http\Request;

use Session;

class QuotationRemarkController extends Controller
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

	public function show(QuotRemark $quotRem)
	{
	//
	}

	public function edit(QuotRemark $quotRem)
	{
	}

	public function update(Request $request, QuotRemark $quotRem)
	{
	//
	}

	public function destroy(QuotRemark $quotRem)
	{
		// $quotRem->destroy();
		QuotRemark::destroy($quotRem->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}

