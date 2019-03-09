<?php
use \App\Model\CSOrder;
use \App\Model\CSOrderItem;

use \Carbon\Carbon;
?>
<table class="table table-hover table-sm" style="font-size:12px" id="orderitem1">
	<thead>
		<tr>
			<th>ID</th>
			<th>Date</th>
			<th>Customer</th>
			<th>Requester</th>
			<th>Informed By</th>
			<th>PIC</th>
			<th>Remarks</th>
			<th>Item/Part</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
@foreach(CSOrder::all() as $cs)
		<tr>
			<td>{!! $cs->id !!}</td>
			<td>{!! Carbon::parse($cs->date)->format('D, j F Y') !!}</td>
			<td>{!! $cs->belongtocustomer->customer !!}</td>
			<td>{!! $cs->requester !!}</td>
			<td>{!! $cs->belongtoinformerorder->name !!}</td>
			<td>{!! $cs->belongtopic->name !!}</td>
			<td>{!! $cs->remarks !!}</td>
			<td>
@if($cs->hasmanyorderitem()->get()->count())
				<table class="table table-hover table-sm" style="font-size:12px" id="orderitem2">
					<thead>
						<tr>
							<th>Order Item/part</th>
							<th>Status</th>
							<th>Remarks</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
@foreach($cs->hasmanyorderitem()->get() as $csoi)
						<tr>
							<td>{!! $csoi->order_item !!}</td>
							<td>{!! $csoi->belongtoorderstatus->order_item_status !!}</td>
							<td>{!! $csoi->description !!}</td>
							<td>
								<span class="text-danger deletecsoi" data-id="{!! $csoi->id !!}" title="Delete"><i class="far fa-trash-alt"></i></span>
							</td>
						</tr>
@endforeach
					</tbody>
				</table>
@endif
			</td>
			<td>
				<a href="{!! route('csOrder.edit', $cs->id) !!}" title="Update"><i class="far fa-edit"></i></a>
				<span class="text-danger deletecs" data-id="{!! $cs->id !!}" title="Delete"><i class="far fa-trash-alt"></i></span>
			</td>
		</tr>
@endforeach
	</tbody>
</table>