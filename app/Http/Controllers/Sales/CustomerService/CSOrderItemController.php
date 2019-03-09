<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\CSOrder;
use App\Model\CSOrderItem;

use Illuminate\Http\Request;

use Session;

class CSOrderItemController extends Controller
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

	public function show(CSOrderItem $csOrderItem)
	{
	//
	}

	public function edit(CSOrderItem $csOrderItem)
	{
	}

	public function update(Request $request, CSOrderItem $csOrderItem)
	{
	//
	}

	public function destroy(CSOrderItem $csOrderItem)
	{
		CSOrderItem::destroy($csOrderItem->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
