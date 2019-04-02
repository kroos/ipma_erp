<?php

namespace App\Http\Controllers\Sales\Costing;

use App\Http\Controllers\Controller;

// load model
use App\Model\QuotExclusion;

use Illuminate\Http\Request;

use Session;

class QuotationExclusionController extends Controller
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

	public function show(QuotExclusion $quotExcl)
	{
	//
	}

	public function edit(QuotExclusion $quotExcl)
	{
	}

	public function update(Request $request, QuotExclusion $quotExcl)
	{
	//
	}

	public function destroy(QuotExclusion $quotExcl)
	{
		// $quotExcl->destroy();
		QuotExclusion::destroy($quotExcl->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}

