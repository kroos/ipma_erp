<?php

namespace App\Http\Controllers\Sales\Costing;

use App\Http\Controllers\Controller;

// load model
use App\Model\QuotWarranty;

use Illuminate\Http\Request;

use Session;

class QuotationWarrantyController extends Controller
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

	public function show(QuotWarranty $quotWarr)
	{
	//
	}

	public function edit(QuotWarranty $quotWarr)
	{
	}

	public function update(Request $request, QuotWarranty $quotWarr)
	{
	//
	}

	public function destroy(QuotWarranty $quotWarr)
	{
		// $quotWarr->destroy();
		QuotWarranty::destroy($quotWarr->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}

