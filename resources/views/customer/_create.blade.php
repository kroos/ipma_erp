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

		<div class="form-group row {{ $errors->has('email')?'has-error':'' }}">
			{{ Form::label( 'ema', 'Email : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::text('email', @$value, ['class' => 'form-control', 'id' => 'ema', 'placeholder' => 'Email', 'autocomplete' => 'off']) !!}
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