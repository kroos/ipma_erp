<?php

namespace App\Http\Controllers\Sales\Costing;

use App\Http\Controllers\Controller;

// load model
use App\Model\QuotItem;

use Illuminate\Http\Request;

use Session;

class QuotationItemController extends Controller
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

	public function show(QuotItem $quotItem)
	{
	//
	}

	public function edit(QuotItem $quotItem)
	{
	}

	public function update(Request $request, QuotItem $quotItem)
	{
	//
	}

	public function destroy(QuotItem $quotItem)
	{
		// $quotItem->destroy();
		QuotItem::destroy($quotItem->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}

