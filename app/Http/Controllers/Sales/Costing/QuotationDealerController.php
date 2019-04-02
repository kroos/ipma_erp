<?php

namespace App\Http\Controllers\Sales\Costing;

use App\Http\Controllers\Controller;

// load model
use App\Model\QuotDealer;

use Illuminate\Http\Request;

use Session;

class QuotationDealerController extends Controller
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

	public function show(QuotDealer $quotDeal)
	{
	//
	}

	public function edit(QuotDealer $quotDeal)
	{
	}

	public function update(Request $request, QuotDealer $quotDeal)
	{
	//
	}

	public function destroy(QuotDealer $quotDeal)
	{
		// $quotDeal->destroy();
		QuotDealer::destroy($quotDeal->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}

