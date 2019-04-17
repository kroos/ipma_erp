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
		{!! Form::text('tax_value', @$value, ['class' => 'form-control form-control-sm gstvalue', 'id' => 'tax_value', 'placeholder' => 'GST Value (%)', 'autocomplete' => 'off']) !!}
	</div>
</div>

<!-- grand total -->
<div class="form-row row col-12">
	<div class="col-3 offset-8">
		<label for="grandtotal" class="col col-form-label">Grand Total :</label>
	</div>
	<div class="form-group col-1">
		<input type="text" value="0.00" class="form-control form-control-sm grandtotal" id="grandtotal" disabled="disabled">
	</div>
</div>

<!-- less special discount -->
<div class="form-row row col-12">
	<div class="col-3 offset-8">
		<label for="discount" class="col col-form-label">Less Special Discount :</label>
	</div>
	<div class="form-group col-1">
		{!! Form::text('discount', @$value, ['class' => 'form-control form-control-sm discount', 'id' => 'discount', 'placeholder' => 'Less Special Discount', 'autocomplete' => 'off']) !!}
	</div>
</div>

<!-- nett Total -->
<div class="form-row row col-12">
	<div class="col-3 offset-8">
		<label for="grandtotal" class="col col-form-label">Nett Total :</label>
	</div>
	<div class="form-group col-1">
		<input type="text" value="0.00" class="form-control form-control-sm netttotal" id="netttotal" disabled="disabled">
	</div>
</div>

<p>&nbsp;</p>
<!-- dealer price -->
<div class="form-group row {{ $errors->has('dealer_price')?'has-error':NULL }}">
	{{ Form::label( 'dp', 'Recommended Selling Price For Dealer : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class="col-sm-10">
		{!! Form::text('dealer_price', @$value, ['class' => 'form-control form-control-sm', 'id' => 'dp', 'placeholder' => 'Recommended Selling Price For Dealer']) !!}
	</div>
</div>

<!-- dealer clause -->
<div class="row">
	{{ Form::label( 'dealer', 'Dealer Clause : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class=" col-10">

		<div class="dealer_wrapper">

		</div>
		<div class="row col-3 dealer_add">
			<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Dealer</p>
		</div>

	</div>
</div>

<!-- delivery date -->
<div class="row">
	{{ Form::label( 'ddp', 'Delivery Date : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class="col">
		<div class="form-row">
			<div class="form-group col-1 {{ $errors->has('mutual')?'has-error':NULL }}">
				<div class="pretty p-icon p-round p-pulse" >
					{!! Form::radio('mutual', 0, @$value) !!}
					<small id="radio1button" class="form-text text-danger mutu"></small>
					<div class="state p-success">
						<i class="icon mdi mdi-check"></i>
						<label >&nbsp;</label>
					</div>
				</div>
			</div>
		<div class="form-group col-2 {{ $errors->has('from')?'has-error':NULL }}">{!! Form::text('from', @$value, ['class' => 'form-control form-control-sm', 'id' => 'ddf', 'placeholder' => 'From']) !!}</div> to 
		<div class="form-group col-2 {{ $errors->has('to')?'has-error':NULL }}">{!! Form::text('to', @$value, ['class' => 'form-control form-control-sm', 'id' => 'ddf', 'placeholder' => 'To']) !!}</div>
		<div class="form-group col-2 {{ $errors->has('period_id')?'has-error':NULL }}">{!! Form::select('period_id', \App\Model\QuotDeliveryDate::pluck('delivery_date_period', 'id')->toArray(), @$value, ['class' => 'form-control form-control-sm', 'id' => 'ddp', 'placeholder' => 'Please choose']) !!}</div>  upon confirmation of order and receipt of down payment. 
		</div>
		<div class="form-row">
			<div class="form-check col-2 {{ $errors->has('mutual')?'has-error':NULL }}">
				<div class="pretty p-icon p-round p-pulse" >
					{!! Form::radio('mutual', 1, @$value) !!}
					<small id="radio2button" class="form-text text-danger mutu"></small>
					<div class="state p-success">
						<i class="icon mdi mdi-check"></i>
						<label >Mutually Agreed</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<br />

<div class="row">
	{{ Form::label( 'valid', 'Validity : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class="form-row col-10">
		<div class="form-group col-2 {{ $errors->has('validity')?'has-error':NULL }}">{!! Form::text('validity', @$value, ['class' => 'form-control form-control-sm', 'id' => 'valid', 'placeholder' => 'Validity']) !!}</div> days from quotation date.
	</div>
</div>

<div class="row">
	{{ Form::label( 'top', 'Term Of Payment : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class=" col-10">

		<div class="top_wrapper">
			<div class="row top_row">
				<div class="col-1 text-danger top_remove" data-id="1">
					<i class="fas fa-trash" aria-hidden="true"></i>
				</div>
				<div class="form-group col {{ $errors->has('qstop.*.term_of_payment') ? 'has-error' : '' }}">
					<input type="text" name="qstop[1][term_of_payment]" id="top_1" class="form-control form-control-sm" placeholder="Term Of Payment">
				</div>
			</div>
		</div>
		<div class="row col-3 top_add">
			<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Term Of Payment</p>
		</div>

	</div>
</div>

<!-- exclusion -->
<div class="row">
	{{ Form::label( 'exclude', 'Exclusions : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class=" col-10">

		<div class="exc_wrapper">
			<div class="row exc_row">
				<div class="col-1 text-danger exc_remove" data-id="1">
					<i class="fas fa-trash" aria-hidden="true"></i>
				</div>
				<div class="form-group col {{ $errors->has('qsexclusions.*.exclusion_id') ? 'has-error' : '' }}">
					<select name="qsexclusions[1][exclusion_id]" class="form-control form-control-sm" id="exclusion_1" placeholder="Please choose">
						<option value="">Please choose</option>
@foreach(\App\Model\QuotExclusion::all() as $exc)
						<option value="{!! $exc->id !!}">{!! $exc->exclusion !!}</option>
@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="row col-3 exc_add">
			<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Exclusions</p>
		</div>

	</div>
</div>

<!-- remarks -->
<div class="row">
	{{ Form::label( 'remarks', 'Remarks : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class=" col-10">

		<div class="rem_wrapper">
			<div class="row rem_row">
				<div class="col-1 text-danger rem_remove" data-id="1">
					<i class="fas fa-trash" aria-hidden="true"></i>
				</div>
				<div class="form-group col {{ $errors->has('qsremark.*.exclusion_id') ? 'has-error' : '' }}">
					<select name="qsremark[1][remark_id]" class="form-control form-control-sm" id="remark_1" placeholder="Please choose">
						<option value="">Please choose</option>
@foreach(\App\Model\QuotRemark::all() as $rem)
						<option value="{!! $rem->id !!}">{!! $rem->quot_remarks !!}</option>
@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="row col-3 rem_add">
			<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Remarks</p>
		</div>

	</div>
</div>

<!-- warranty -->
<div class="row">
	{{ Form::label( 'warr', 'Warranty : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class=" col-10">
		<div class="warranty_wrapper">
		</div>
		<div class="row col-3 warranty_add">
			<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Warranty</p>
		</div>

	</div>
</div>


<!-- bank -->
<div class="row">
	{{ Form::label( 'bnk', 'Bank : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class="row col-10">

@foreach(\App\Model\QuotBank::all() as $dea)

<div class="col-6">
	<div class="card">
		<div class="card-header">
			<div class="form-group {{ $errors->has('bank_id')?'has-error':NULL }}">
				<input type="radio" name="bank_id" value="{!! $dea->id !!}" aria-describedby="emailHelp_{!! $dea->id !!}" id="bank_{!! $dea->id !!}" >
				<label for="bank_{!! $dea->id !!}">Option {!! $dea->id !!}</label>
				<small id="emailHelp_{!! $dea->id !!}" class="form-text text-muted">Click again to remove this option.</small>
			</div>
		</div>
		<div class="card-body">
			{!! nl2br($dea->bank) !!}
		</div>
	</div>
</div>

@endforeach

	</div>
</div>

<!-- grand amount -->
<div class="form-group row">
	{!! Form::label('gamount', 'Grand Amount : ', ['class' => 'col-form-label col-2']) !!}
	<div class="col-10">
		{!! Form::text('grandamount', @$value, ['class' => 'form-control form-control-sm', 'id' => 'gamount', 'placeholder' => 'Grand Amount In English']) !!}
	</div>
</div>

<!-- budget quot -->
<div class="form-check  {{ $errors->has('budget_quot')?'has-error':NULL }}">
	<div class="pretty p-icon p-round p-pulse">
		<input type="hidden" value="0" name="budget_quot">
		{!! Form::checkbox('budget_quot', 1, NULL, ['class' => 'form-check-input', 'id' => 'bq']) !!}
		<div class="state p-success">
			<i class="icon mdi mdi-check"></i>
			{!! Form::label('bq', 'Budget Quotation', ['class' => 'form-check-label']) !!}
		</div>
	</div>
</div>

<p>&nbsp;</p>
<div class="form-group row">
	<div class="col-10 offset-2">
		{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
	</div>
</div>