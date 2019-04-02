<?php

namespace App\Http\Controllers\Sales\Costing;

use App\Http\Controllers\Controller;

// load model
use App\Model\QuotBank;

use Illuminate\Http\Request;

use Session;

class QuotationBankController extends Controller
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

	public function show(QuotBank $quotBank)
	{
	//
	}

	public function edit(QuotBank $quotBank)
	{
	}

	public function update(Request $request, QuotBank $quotBank)
	{
	//
	}

	public function destroy(QuotBank $quotBank)
	{
		// $quotBank->destroy();
		QuotBank::destroy($quotBank->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}

