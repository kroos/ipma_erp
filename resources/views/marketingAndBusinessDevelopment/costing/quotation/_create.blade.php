<div class="card">
	<div class="card-header">Customer</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('date')?'has-error':'' }}">
			{{ Form::label( 'dat', 'Date : ', ['class' => 'col-2 col-form-label'] ) }}
			<div class="col-10">
				{!! Form::text('date', @$value, ['class' => 'form-control form-control-sm', 'id' => 'dat', 'placeholder' => 'Date', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('currency_id')?'has-error':'' }}">
			{{ Form::label( 'curr', 'Currency Quotation : ', ['class' => 'col-2 col-form-label'] ) }}
			<div class="col-10">
				{!! Form::select('currency_id', \App\Model\Currency::pluck('currency' ,'id')->toArray(), @$value, ['class' => 'form-control form-control-sm', 'id' => 'curr', 'placeholder' => 'Please choose', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('customer_id')?'has-error':'' }}">
			{{ Form::label( 'cust', 'Customer : ', ['class' => 'col-2 col-form-label'] ) }}
			<div class="col-10">
				{!! Form::select('customer_id', \App\Model\Customer::pluck('customer', 'id')->toArray(), @$value, ['class' => 'form-control form-control-sm', 'id' => 'cust', 'placeholder' => 'Please choose'] ) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('attn')?'has-error':'' }}">
			{{ Form::label( 'att', 'Attention To : ', ['class' => 'col-2 col-form-label'] ) }}
			<div class="col-10">
				{!! Form::text('attn', @$value, ['class' => 'form-control form-control-sm', 'id' => 'att', 'placeholder' => 'Attention To', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('subject')?'has-error':'' }}">
			{{ Form::label( 'subj', 'Subject : ', ['class' => 'col-2 col-form-label'] ) }}
			<div class="col-10">
				{!! Form::text('subject', @$value, ['class' => 'form-control form-control-sm', 'id' => 'subj', 'placeholder' => 'Subject', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('description')?'has-error':'' }}">
			{{ Form::label( 'rem', 'Remarks : ', ['class' => 'col-2 col-form-label'] ) }}
			<div class="col-10">
				{!! Form::textarea('description', @$value, ['class' => 'form-control form-control-sm', 'id' => 'rem', 'placeholder' => 'Remarks', 'autocomplete' => 'off']) !!}
			</div>
		</div>

	</div>
</div>
<p>Thank you very much for your enquiry of the above. We are pleased to quote below for your kind consideration:</p>

<!-- wrapper for section -->
<div class="col section_wrapper">
</div>

<div class="row col-2 section_add">
	<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Section</p>
</div>

<!-- GST -->
<div class="form-row row col-12">
	<div class="form-group col-2 offset-8">
		<label for="tax_id" class="col col-form-label">GST TAX :</label>
	</div>
	<div class="form-group col-1 {{ $errors->has('tax_id') ? 'has-error' : '' }}">
		<select name="tax_id" id="tax_id" class="form-control form-control-sm gst" autocomplete="off" placeholder="Please choose" >
			<option value="">Please choose</option>
@foreach(\App\Model\Tax::all() as $tax)
			<option value="{!! $tax->id !!}" data-taxvalue="{!! $tax->value !!}">{!! $tax->tax !!}</option>
@endforeach
		</select>
	</div>
	<div class="form-group col-1 {{ $errors->has('tax_value') ? 'has-error' : '' }}">
		{!! Form::text('tax_value', @$value, ['class' => 'form-control form-control-sm gstvalue', 'id' => 'tax_value', 'placeholder' => 'GST Value', 'autocomplete' => 'off']) !!}
	</div>
</div>

<!-- grand total -->
<div class="form-row row col-12">
	<div class="form-group col-3 offset-8">
		<label for="grandtotal" class="col col-form-label">Grand Total :</label>
	</div>
	<div class="form-group col-1">
		<input type="text" value="0.00" class="form-control form-control-sm grandtotal" id="grandtotal" disabled="disabled">
	</div>
</div>









<p>&nbsp;</p>
<div class="form-group row">
	<div class="col-10 offset-2">
		{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
	</div>
</div>