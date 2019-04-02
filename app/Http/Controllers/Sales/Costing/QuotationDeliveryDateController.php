<?php

namespace App\Http\Controllers\Sales\Costing;

use App\Http\Controllers\Controller;

// load model
use App\Model\QuotDeliveryDate;

use Illuminate\Http\Request;

use Session;

class QuotationDeliveryDateController extends Controller
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

	public function show(QuotDeliveryDate $quotdd)
	{
	//
	}

	public function edit(QuotDeliveryDate $quotdd)
	{
	}

	public function update(Request $request, QuotDeliveryDate $quotdd)
	{
	//
	}

	public function destroy(QuotDeliveryDate $quotdd)
	{
		// $quotdd->destroy();
		QuotDeliveryDate::destroy($quotdd->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}

