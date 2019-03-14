<div class="row">
	<div class="col-6">
		<div class="form-group row {{ $errors->has('date')?'has-error':'' }}">
			{{ Form::label( 'dat', 'Date : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::text('date', @$value, ['class' => 'form-control form-control-sm', 'id' => 'dat', 'placeholder' => 'Date', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('customer_id')?'has-error':'' }}">
			{{ Form::label( 'cust', 'Customer : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::select('customer_id', \App\Model\Customer::pluck('customer', 'id')->toArray(), @$value, ['class' => 'form-control form-control-sm', 'id' => 'cust', 'placeholder' => 'Please choose', 		'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('requester')?'has-error':'' }}">
			{{ Form::label( 'req', 'Requester : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::text('requester', @$value, ['class' => 'form-control form-control-sm', 'id' => 'req', 'placeholder' => 'Requester', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('customer_PO_no')?'has-error':'' }}">
			{{ Form::label( 'custpono', 'Customer PO No : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::text('customer_PO_no', @$value, ['class' => 'form-control form-control-sm', 'id' => 'custpono', 'placeholder' => 'Customer PO No', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('informed_by')?'has-error':'' }}">
			{{ Form::label( 'iby', 'Informed By : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::select('informed_by', \App\Model\Staff::where('active', 1)->pluck('name', 'id')->toArray(), @$value, ['class' => 'form-control form-control-sm', 'id' => 'iby', 'placeholder' => 		'Please choose', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('pic')?'has-error':'' }}">
			{{ Form::label( 'pi', 'Person In Charge : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::select('pic', \App\Model\Staff::where('active', 1)->pluck('name', 'id')->toArray(), @$value, ['class' => 'form-control form-control-sm', 'id' => 'pi', 'placeholder' => 'Please 		choose', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('description')?'has-error':'' }}">
			{{ Form::label( 'rem', 'Remarks : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::textarea('description', @$value, ['class' => 'form-control form-control-sm', 'id' => 'rem', 'placeholder' => 'Remarks', 'autocomplete' => 'off']) !!}
			</div>
		</div>

	</div>

	<div class="col-6">
		<div class="col orderitem_wrap">

			<div class="roworderitem">
				<div class="col-sm-12 form-row ">
					<div class="col-sm-1 text-danger">
							<i class="fas fa-trash remove_item" aria-hidden="true" id="delete_item_1"></i>
					</div>
					<div class="form-group col {{ $errors->has('csoi.*.order_item') ? 'has-error' : '' }}">
						<input name="csoi[1][order_item]" type="text" value="{!! @$value !!}" class="form-control form-control-sm" id="oi_1" autocomplete="off" placeholder="Item/Parts" />
					</div>
					<div class="form-group col {{ $errors->has('csoi.*.item_additional_info') ? 'has-error' : NULL }}">
						<input type="text" name="csoi[1][item_additional_info]" class="form-control form-control-sm" id="oiai_1" autocomplete="off" placeholder="Item Additional Info" />
					</div>
					<div class="form-group col {{ $errors->has('csoi.*.order_item_status_id') ? 'has-error' : '' }}">
						<select name="csoi[1][order_item_status_id]" id="ois_1" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">
							<option value="">Please choose</option>
@foreach( \App\Model\CSOrderItemStatus::all() as $mod )
							<option value="{!! $mod->id !!}">{!! $mod->order_item_status !!}</option>
@endforeach
						</select>
					</div>
					<div class="form-group col {{ $errors->has('csoi.*.description') ? 'has-error' : '' }}">
						<textarea name="csoi[1][description]" id="oid_1" class="form-control form-control-sm" placeholder="Remarks for Item"></textarea>
					</div>
				</div>
			</div>

		</div>
		<div class="row col-lg-12 add_orderitem">
			<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Order Item</span>
		</div>
	</div>

</div>

<div class="form-group row">
	<div class="col-sm-10 offset-sm-2">
		{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
	</div>
</div>