<div class="col-8 offset-2">
	<table  class="table table-hover table-sm" style="font-size:12px" id="orderitem1">
		<thead>
			<tr>
				<th>ID</th>
				<th>Order Item/Part</th>
				<th>Item Additional Info</th>
				<th>Quantity</th>
			</tr>
		</thead>
		<tbody>
@foreach($item as $id)
			<tr>
				<td>{!! $id->id !!}</td>
				<td>{!! $id->order_item !!} {!! Form::hidden('orderitem[]', $id->id) !!}</td>
				<td>{!! $id->item_additional_info !!}</td>
				<td>{!! $id->quantity !!}</td>
			</tr>
@endforeach
		</tbody>
	</table>
</div>

<div class="form-group row {{ $errors->has('customer_id')?'has-error':'' }}">
	{{ Form::label( 'dat', 'Date : ', ['class' => 'col-sm-2 col-form-label'] ) }}
	<div class="col-sm-10">
		{!! Form::text('delivery_date', @$value, ['class' => 'form-control form-control-sm', 'id' => 'dat', 'placeholder' => 'Delivery Date', 'autocomplete' => 'off']) !!}
	</div>
</div>

<div class="form-group row {{ $errors->has('date')?'has-error':'' }}">
	{{ Form::label( 'dm', 'Delivery Method : ', ['class' => 'col-sm-2 col-form-label'] ) }}
	<div class="col-sm-10">
		{!! Form::select('delivery_id', \App\Model\CSOrderDelivery::pluck('delivery_method', 'id')->toArray(), @$value, ['class' => 'form-control form-control-sm', 'id' => 'dm', 'placeholder' => 'Please choose', 'autocomplete' => 'off']) !!}
	</div>
</div>

<div class="form-group row {{ $errors->has('customer_id')?'has-error':'' }}">
	{{ Form::label( 'cust', 'Remarks : ', ['class' => 'col-sm-2 col-form-label'] ) }}
	<div class="col-sm-10">
		{!! Form::textarea('delivery_remarks', @$value, ['class' => 'form-control form-control-sm', 'id' => 'cust', 'placeholder' => 'Delivery Remarks', 'autocomplete' => 'off']) !!}
	</div>
</div>

<div class="form-group row">
	<div class="col-sm-10 offset-sm-2">
		{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
	</div>
</div>