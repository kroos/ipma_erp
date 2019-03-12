<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\CSOrder;
use App\Model\CSOrderItem;

use Illuminate\Http\Request;

use Session;

class CSOrderController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('marketingAndBusinessDevelopment.customerservice.order_item.index');
	}

	public function create()
	{
		return view('marketingAndBusinessDevelopment.customerservice.order_item.create');
	}

	public function store(Request $request)
	{
		$csoi = CSOrder::create($request->only(['date', 'customer_id', 'requester', 'informed_by', 'pic', 'description']));
		if ($request->has('csoi')) {
			foreach ($request->csoi as $key => $value) {
				$csoi->hasmanyorderitem()->create([
					'order_item' => $value['order_item'],
					'order_item_status_id' => $value['order_item_status_id'],
					'description' => $value['description'],
				]);
			}
		}
		Session::flash('flash_message', 'Data successfully stored!');
		return redirect( route('csOrder.index') );
	}

	public function show(CSOrder $csOrder)
	{
	//
	}

	public function edit(CSOrder $csOrder)
	{
		return view('marketingAndBusinessDevelopment.customerservice.order_item.edit', compact('csOrder'));
	}

	public function update(Request $request, CSOrder $csOrder)
	{
		$csOrder->update($request->only(['date', 'customer_id', 'requester', 'informed_by', 'pic', 'description']));

		// item
		if ($request->has('csoi')) {
			$csOrder->hasmanyorderitem()->delete();
			foreach( $request->csoi as $key => $val ) {
				$csOrder->hasmanyorderitem()->create([
					'order_item' => $val['order_item'],
					'order_item_status_id' => $val['order_item_status_id'],
					'description' => $val['description'],
				]);
			}
		}
		Session::flash('flash_message', 'Data successfully updated!');
		return redirect( route('csOrder.index') );
	}

	public function destroy(CSOrder $csOrder)
	{
		$csOrder->hasmanyorderitem()->delete();
		CSOrder::destroy($csOrder->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
