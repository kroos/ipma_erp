<?php
use \App\Model\CSOrder;
use \App\Model\CSOrderItem;

use \Carbon\Carbon;
?>
<div class="card">
	<div class="card-header">Customer Order Item/Part List</div>
	<div class="card-body">

		<table class="table table-hover table-sm" style="font-size:12px" id="orderitem1">
			<thead>
				<tr>
					<th>Ref No</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Requester</th>
					<th>Customer PO No</th>
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
					<td>COP-{!! $cs->id !!}</td>
					<td>{!! Carbon::parse($cs->date)->format('D, j M Y') !!}</td>
					<td>{!! $cs->belongtocustomer->customer !!}</td>
					<td>{!! $cs->requester !!}</td>
					<td>{!! $cs->customer_PO_no !!}</td>
					<td>{!! $cs->belongtoinformerorder->name !!}</td>
					<td>{!! $cs->belongtopic->name !!}</td>
					<td>{!! $cs->remarks !!}</td>
					<td>
		@if($cs->hasmanyorderitem()->get()->count())
						{!! Form::open(['route' => ['csOrder.delivery'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
						<table class="table table-hover table-sm" style="font-size:12px" id="orderitem2">
							<thead>
								<tr>
									<th>Order Item/Part</th>
									<th>Quantity</th>
									<th>Status</th>
									<th>Remarks</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
		@foreach($cs->hasmanyorderitem()->get() as $csoi)
								<tr>
									<td>
										{!! $csoi->order_item !!}<br />
										{!! $csoi->item_additional_info !!}
									</td>
									<td>{!! $csoi->quantity !!}</td>
									<td>{!! $csoi->belongtoorderstatus->order_item_status !!}</td>
									<td>{!! $csoi->description !!}</td>
									<td>
		@if($csoi->order_item_status_id == 3 && is_null($csoi->delivery_id))
										{!! Form::checkbox('print[]', $csoi->id) !!}
		@endif
										<span class="text-danger deletecsoi" data-id="{!! $csoi->id !!}" title="Delete"><i class="far fa-trash-alt"></i></span>
									</td>
								</tr>
		@endforeach
							</tbody>
		@if($csoi->order_item_status_id == 3 && is_null($csoi->delivery_id))
							<tfoot>
								<tr>
									<th colspan="4">&nbsp;</th>
									<th>{!! Form::submit('Print', ['class' => 'btn btn-primary btn-sm btn-block']) !!}</th>
								</tr>
							</tfoot>
		@endif
						</table>
						{!! Form::close() !!}
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

	</div>
</div>
<p>&nbsp;</p>

<div class="card">
	<div class="card-header">Customer Order Item/Part Delivered</div>
	<div class="card-body">
		<table class="table table-hover table-sm" style="font-size:12px" id="orderitem3">
			<thead>
				<tr>
					<th>Ref No</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Informed By</th>
					<th>Item/Part</th>
				</tr>
			</thead>
			<tbody>
@foreach(CSOrder::all() as $cs)

	@foreach( $cs->hasmanyorderitem()->get() as $v1 )
		@if(!is_null($v1->delivery_id))
				<tr>
					<td>COP-{!! $cs->id !!}</td>
					<td>{!! Carbon::parse($cs->date)->format('D, j M Y') !!}</td>
					<td>{!! $cs->belongtocustomer->customer !!}</td>
					<td>{!! $cs->belongtoinformerorder->name !!}</td>
					<td>
						<table class="table table-hover table-sm" style="font-size:12px" id="orderitem4">
							<thead>
								<tr>
									<th>ID</th>
									<th>Item/Part</th>
									<th>Quantity</th>
									<th>Remarks</th>
									<th>Delivery Instructions</th>
									<th>Delivery Date</th>
									<th>Delivery Remarks</th>
								</tr>
							</thead>
							<tbody>
				@foreach($cs->hasmanyorderitem()->get() as $v)
					@if( !is_null($v->delivery_id) )
								<tr>
									<td>{!! $v->id !!}</td>
									<td>{!! $v->order_item !!}</td>
									<td>{!! $v->quantity !!}</td>
									<td>{!! $v->description !!}</td>
									<td>{!! $v->belongtoorderdelivery->delivery_method !!}</td>
									<td>{!! Carbon::parse($v->delivery_date)->format('j M Y') !!}</td>
									<td>{!! $v->delivery_remarks !!}</td>
								</tr>
					@endif
				@endforeach
							</tbody>
						</table>
					</td>
				</tr>

		@endif
	@endforeach
@endforeach
			</tbody>
		</table>
	</div>
</div>