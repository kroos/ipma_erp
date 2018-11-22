<?php
// load model
use \App\Model\Customer;


$cust = Customer::all();
?>
<div class="col-sm-12">
	<div class="card">
		<div class="card-header">Service Report</div>
		<div class="card-body">

			<div class="row">
				<div class="col form-group {{ $errors->has('date')?'has-error':'' }}">
					{!! Form::text('date', @$value, ['class' => 'form-control', 'id' => 'date', 'placeholder' => 'Date', 'autocomplete' => 'off']) !!}
				</div>
				<div class="col form-group {{ $errors->has('serial')?'has-error':'' }}">
					{!! Form::text('serial', @$value, ['class' => 'form-control', 'id' => 'serial', 'placeholder' => 'Service Report No.', 'autocomplete' => 'off']) !!}
				</div>
			</div>

			<div class="form-check form-check-inline">
				<label class="form-check-label" for="inlineRadio1">Charge : </label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
				<label class="form-check-label" for="inlineRadio1">1</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
				<label class="form-check-label" for="inlineRadio2">2</label>
			</div>


		</div>
	</div>
</div>
<br />
<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Customer</div>
			<div class="card-body">

				<div class="form-group row {{ $errors->has('customer_id')?'has-error':'' }}">
					{{ Form::label( 'cust', 'Customer : ', ['class' => 'col-sm-2 col-form-label'] ) }}
					<div class="col-sm-10">
						<select name="customer_id" id="cust" class="form-control col-sm-12" autocomplete="off">
							<option value="" data-pc="" data-phone="">Please choose</option>
@foreach($cust as $cu)
							<option value="{!! $cu->id !!}" data-pc="{!! $cu->pc !!}" data-phone="{!! $cu->phone !!}">{!! $cu->customer !!}</option>
@endforeach
						</select>
					</div>
				</div>


				<dl class="row">
					<dt class="col-sm-5">Attention To :</dt>
					<dd class="col-sm-7" id="attn"></dd>

					<dt class="col-sm-5">Phone :</dt>
					<dd class="col-sm-7" id="phone"></dd>
				</dl>

			</div>
		</div>
	</div>

	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">asd</div>
			<div class="card-body">asd</div>
		</div>
	</div>
</div>



<div class="form-group row">
	<div class="col-sm-10 offset-sm-2">
		{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
	</div>
</div>