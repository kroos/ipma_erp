<?php

namespace App\Http\Controllers\Sales\Costing;

use App\Http\Controllers\Controller;

// load model
use App\Model\QuotUOM;

use Illuminate\Http\Request;

use Session;

class QuotationUOMController extends Controller
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

	public function show(QuotUOM $quotUOM)
	{
	//
	}

	public function edit(QuotUOM $quotUOM)
	{
	}

	public function update(Request $request, QuotUOM $quotUOM)
	{
	//
	}

	public function destroy(QuotUOM $quotUOM)
	{
		// $quotUOM->destroy();
		QuotUOM::destroy($quotUOM->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}

