<?php

namespace App\Http\Controllers\Sales\Costing;

use App\Http\Controllers\Controller;

// load model
use App\Model\QuotItemAttribute;

use Illuminate\Http\Request;

use Session;

class QuotationItemAttributeController extends Controller
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

	public function show(QuotItemAttribute $quotItemAttrib)
	{
	//
	}

	public function edit(QuotItemAttribute $quotItemAttrib)
	{
	}

	public function update(Request $request, QuotItemAttribute $quotItemAttrib)
	{
	//
	}

	public function destroy(QuotItemAttribute $quotItemAttrib)
	{
		// $quotItemAttrib->destroy();
		QuotItemAttribute::destroy($quotItemAttrib->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}

