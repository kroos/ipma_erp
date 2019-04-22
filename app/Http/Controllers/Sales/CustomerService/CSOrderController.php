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
		$csoi = CSOrder::create($request->only(['date', 'customer_id', 'requester', 'customer_PO_no', 'informed_by', 'pic', 'description']));
		if ($request->has('csoi')) {
			foreach ($request->csoi as $key => $value) {
				$csoi->hasmanyorderitem()->create([
					'order_item' => $value['order_item'],
					'item_additional_info' => $value['item_additional_info'],
					'quantity' => $value['quantity'],
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
		return view('marketingAndBusinessDevelopment.customerservice.order_item.showpdf', compact(['csOrder']));
	}

	public function edit(CSOrder $csOrder)
	{
		return view('marketingAndBusinessDevelopment.customerservice.order_item.edit', compact('csOrder'));
	}

	public function update(Request $request, CSOrder $csOrder)
	{
		$csOrder->update($request->only(['date', 'customer_id', 'requester', 'customer_PO_no', 'informed_by', 'pic', 'description']));

		// item
		if ($request->has('csoi')) {
			// $csOrder->hasmanyorderitem()->delete();
			foreach( $request->csoi as $key => $val ) {
				// $csOrder->hasmanyorderitem()->updateOrCreate([
				CSOrderItem::updateOrCreate(
					[
						'id' => $val['id']
					],
					[
						'order_id' => $val['order_id'],
						'order_item' => $val['order_item'],
						'item_additional_info' => $val['item_additional_info'],
						'quantity' => $val['quantity'],
						'order_item_status_id' => $val['order_item_status_id'],
						'description' => $val['description']
					]
				);
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

	public function delivery(Request $request)
	{
		// print_r(request()->all());
		// $pr = [];
		// $pr1 = '';
		// if ($request->has('print')){
			// foreach($request->print as $k => $v) {
				// $pr[] = $v;
				// $pr1 .= 'orderitem='.$v.'&';
			// }
		// }
		// print_r($pr);
		// echo '<br />';
		// echo $pr1.'<br />';
		// echo CSOrderItem::whereIn('id', $pr)->get();
		$item = CSOrderItem::whereIn('id', $request->print)->get();
		return view('marketingAndBusinessDevelopment.customerservice.order_item.deliverymethodupdate', compact('item'));
	}

	public function deliverymethodstore(Request $request)
	{
		$did = CSOrderItem::whereIn('id', $request->orderitem)->update($request->only(['delivery_date', 'delivery_id', 'delivery_remarks']));
		echo view('pdfleave.orderitemdeliverymethod', compact('request'));
	}
}
