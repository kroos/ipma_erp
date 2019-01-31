<div class="card">
	<div class="card-header">Add Customer</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('customer')?'has-error':'' }}">
			{{ Form::label( 'cust', 'Customer : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::text('customer', @$value, ['class' => 'form-control', 'id' => 'cust', 'placeholder' => 'Customer', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('pc')?'has-error':'' }}">
			{{ Form::label( 'pc', 'Person In Charge : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::text('pc', @$value, ['class' => 'form-control', 'id' => 'pc', 'placeholder' => 'Person In Charge', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('address1')?'has-error':'' }}">
			{{ Form::label( 'add1', 'Address : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::text('address1', @$value, ['class' => 'form-control', 'id' => 'add1', 'placeholder' => 'Address', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('address2')?'has-error':'' }}">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::text('address2', @$value, ['class' => 'form-control', 'id' => 'add2', 'placeholder' => 'Address', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('address3')?'has-error':'' }}">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::text('address3', @$value, ['class' => 'form-control', 'id' => 'add3', 'placeholder' => 'Address', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('address4')?'has-error':'' }}">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::text('address4', @$value, ['class' => 'form-control', 'id' => 'add4', 'placeholder' => 'Address', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('phone')?'has-error':'' }}">
			{{ Form::label( 'phone', 'Phone : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::text('phone', @$value, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Phone', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('fax')?'has-error':'' }}">
			{{ Form::label( 'fax', 'Fax : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::text('fax', @$value, ['class' => 'form-control', 'id' => 'fax', 'placeholder' => 'Fax', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>
	</div>
</div>
<p>&nbsp;</p>
	<div class="card">
		<div class="card-header">Customer List</div>
		<div class="card-body">
			<table class="table table-hover table-sm" style="font-size:12px" id="cust11">
				<thead>
					<tr>
						<th>Client</th>
						<th>PIC</th>
						<th>Address</th>
						<th>Phone</th>
						<th>Fax</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
@foreach(\App\Model\Customer::all() as $k)
					<tr>
						<td>{{ $k->customer }}</td>
						<td>{{ $k->pc }}</td>
						<td>
							{{ $k->address1 }}
							<br />{{ $k->address2 }}
							<br />{{ $k->address3 }}
							<br />{{ $k->address4 }}
						</td>
						<td>{{ $k->phone }}</td>
						<td>{{ $k->fax }}</td>
						<td>
							<div class="row">
								<a href="{!! route('customer.edit', $k->id) !!}" title="Update"><i class="far fa-edit"></i></a>
								<span class="text-danger delete_customer" data-id="{!! $k->id !!}" title="Delete"><i class="far fa-trash-alt"></i></span>
							</div>
						</td>
					</tr>
@endforeach
				</tbody>
			</table>
		</div>
	</div>