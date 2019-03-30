<div class="form-group row {{ $errors->has('date')?'has-error':'' }}">
	{{ Form::label( 'dat', 'Date : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class="col-10">
		{!! Form::text('date', @$value, ['class' => 'form-control form-control-sm', 'id' => 'dat', 'placeholder' => 'Date']) !!}
	</div>
</div>

<div class="form-group row {{ $errors->has('currency_id')?'has-error':'' }}">
	{{ Form::label( 'curr', 'Currency Quotation : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class="col-10">
		{!! Form::select('currency_id', \App\Model\Currency::pluck('currency' ,'id')->toArray(), @$value, ['class' => 'form-control form-control-sm', 'id' => 'curr', 'placeholder' => 'Please choose']) !!}
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
		{!! Form::text('attn', @$value, ['class' => 'form-control form-control-sm', 'id' => 'att', 'placeholder' => 'Attention To']) !!}
	</div>
</div>

<div class="form-group row {{ $errors->has('subject')?'has-error':'' }}">
	{{ Form::label( 'subj', 'Subject : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class="col-10">
		{!! Form::text('subject', @$value, ['class' => 'form-control form-control-sm', 'id' => 'subj', 'placeholder' => 'Subject']) !!}
	</div>
</div>

<div class="form-group row {{ $errors->has('description')?'has-error':'' }}">
	{{ Form::label( 'rem', 'Remarks : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class="col-10">
		{!! Form::textarea('description', @$value, ['class' => 'form-control form-control-sm', 'id' => 'rem', 'placeholder' => 'Remarks']) !!}
	</div>
</div>

<!-- revision -->
<div class="row">
	{{ Form::label( 'rev', 'Revision : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class="form-row col-10">
		<div class="form-group col {{ $errors->has('revision') ? 'has-error' : '' }}">
			{!! Form::text('revision', @$value, ['class' => 'form-control form-control-sm', 'id' => 'rev', 'placeholder' => 'Revision Remarks']) !!}
		</div>
		<div class="form-group col {{ $errors->has('revision_file') ? 'has-error' : '' }}">
			{!! Form::file('revision_file', @$value, ['class' => 'form-control-file form-control-file-sm', 'id' => 'rev', 'placeholder' => 'Quot Revision']) !!}
		</div>
	</div>
</div>
<!-- end revision -->

<p>Thank you very much for your enquiry of the above. We are pleased to quote below for your kind consideration:</p>

<!-- wrapper for section -->
<div class="col section_wrapper">
<?php
$gtotal = 0;
$price = 0;
?>
@if( $quot->hasmanyquotsection()->get()->count() )
<?php
// section
$t1 = 1;	// main
$t2 = 1;
$t25 = 1;	// hidden

// item
$t3 = 1;	// main
$t4 = 1;
$t5 = 1;
$t6 = 1;
$t7 = 1;
$t8 = 1;
$t9 = 1;
$t10 = 1;
$t11 = 1;
$t12 = 1;
$t13 = 1;
$t14 = 1;
$t15 = 1;
$t16 = 1;
$t27 = 1;	// hidden

// attribute
$t17 = 1;	// main
$t18 = 1;
$t19 = 1;
$t20 = 1;
$t21 = 1;
$t22 = 1;
$t23 = 1;
$t24 = 1;
$t29 = 1;	// hidden
?>
@foreach( $quot->hasmanyquotsection()->get() as $sect )
			<div class="section_row">
				<div class="card">
					<div class="card-header">Section</div>
					<div class="card-body">
						<div class="row">
							<div class="col-1 text-danger section_delete"  id="section_remove_{{ $sect->id }}" data-sectionid="{!! $sect->id !!}">
								<i class="fas fa-trash" aria-hidden="true"></i>
							</div>
							{!! Form::hidden('qs['.$t25++.'][id]', $sect->id) !!}
							<div class="form-group col-11 {{ $errors->has('qs.*.section') ? 'has-error' : '' }}">
								<input type="text" name="qs[{{ $t1++ }}][section]" value="{!! $sect->section !!}" id="section_{{ $t2++ }}" class="form-control form-control-sm" placeholder="Section Title" />
							</div>
							<div class="col-12">
								<div class="card">
									<div class="card-header">Item</div>
									<div class="card-body">


<!-- wrapper for items -->
										<div class="col item_wrap">
		@if( $sect->hasmanyquotsectionitem()->get()->count() )
			@foreach( $sect->hasmanyquotsectionitem()->get() as $it )
			<?php $pr = ($it->price_unit * $it->quantity ) ?>
			<?php $price += $pr ?>
											<div class="item_row">
												<div class="form-row col-12">
													<div class="col-1 text-danger item_delete" data-sectionid="{!! $sect->id !!}" data-itemid="{!! $it->id !!}">
															<i class="fas fa-trash" aria-hidden="true"></i>
													</div>
													{!! Form::hidden('qs['.($t1-1).'][qssection]['.$t27++.'][id]', $it->id) !!}
													<div class="form-group col {{ $errors->has('qs.*.qssection.*.item_id') ? 'has-error' : '' }}">
														<select name="qs[{!! $t1-1 !!}][qssection][{!! $t3++ !!}][item_id]" id="item_{!! $t1-1 !!}_{!! $t4++ !!}" class="form-control form-control-sm itemprice" placeholder="Please choose">
															<option value="">Please choose</option>
											@foreach(\App\Model\QuotItem::where('active', 1)->get() as $item)
															<option value="{!! $item->id !!}" data-price="{!! $item->price !!}" {!! ($item->id == $it->item_id)?'selected':NULL !!}>{!! $item->item !!}</option>
											@endforeach
														</select>
													</div>
													<div class="form-group col {{ $errors->has('qs.*.qssection.*.price_unit') ? 'has-error' : '' }}">
														<input type="text" name="qs[{!! $t1-1 !!}][qssection][{!! $t5++ !!}][price_unit]" value="{!! $it->price_unit !!}" id="price_unit_{!! $t1-1 !!}_{!! $t6++ !!}" class="form-control form-control-sm priceunit" placeholder="Price/Unit">
													</div>
													<div class="form-group col {{ $errors->has('qs.*.qssection.*.description') ? 'has-error' : '' }}">
														<input type="text" name="qs[{!! $t1-1 !!}][qssection][{!! $t7++ !!}][description]" value="{!! $it->description !!}" id="remarks_{!! $t1-1 !!}_{!! $t8++ !!}" class="form-control form-control-sm" placeholder="Remarks" />
													</div>
													<div class="form-group col {{ $errors->has('qs.*.qssection.*.quantity') ? 'has-error' : '' }}">
														<input type="text" name="qs[{!! $t1-1 !!}][qssection][{!! $t9++ !!}][quantity]" value="{!! $it->quantity !!}" id="quantity_{!! $t1-1 !!}_{!! $t10++ !!}" class="form-control form-control-sm quan" placeholder="Quantity" />
													</div>
													<div class="form-group col {{ $errors->has('qs.*.qssection.*.uom_id') ? 'has-error' : '' }}">
														<select name="qs[{!! $t1-1 !!}][qssection][{!! $t11++ !!}][uom_id]" id="uom_id_{!! $t1-1 !!}_{!! $t12++ !!}" class="form-control form-control-sm" placeholder="Please choose">
															<option value="">Please choose</option>
											@foreach(\App\Model\QuotUOM::all() as $uom)
															<option value="{!! $uom->id !!}" {!!  ($uom->id == $it->uom_id)?'selected':NULL !!}>{!! $uom->uom !!}</option>
											@endforeach
														</select>
													</div>
													<div class="form-group col {{ $errors->has('qs.*.qssection.*.tax_id') ? 'has-error' : '' }}">
														<select type="text" name="qs[{!! $t1-1 !!}][qssection][{!! $t13++ !!}][tax_id]" id="tax_id_{!! $t1-1 !!}_{!! $t14++ !!}" class="form-control form-control-sm tax" placeholder="Please choose" >
															<option value="">Please choose</option>
											@foreach(\App\Model\Tax::all() as $tax)
															<option value="{!! $tax->id !!}" data-taxvalue="{!! $tax->value !!}" {!!  ($tax->id == $it->tax_id)?'selected':NULL !!}>{!! $tax->tax !!}</option>
											@endforeach
														</select>
													</div>
													<div class="form-group col {{ $errors->has('qs.*.qssection.*.tax_value') ? 'has-error' : '' }}">
														<input type="text" name="qs[{!! $t1-1 !!}][qssection][{!! $t15++ !!}][tax_value]" value="{!! $it->tax_value !!}" id="tax_value_{!! $t1-1 !!}_{!! $t16++ !!}" class="form-control form-control-sm taxvalue" placeholder="Tax Value (%)" />
													</div>
													<div class="form col">
														<input type="text" value="{!! ($pr>0)?$pr:'0.00' !!}" class="form-control form-control-sm price" disabled="disabled">
													</div>
												</div>


<!-- wrapper for attribute -->
												<div class="col attrib_wrap">

				@if( $it->hasmanyquotsectionitemattrib()->get()->count() )
					@foreach( $it->hasmanyquotsectionitemattrib()->get() as $att1 )



													<div class="attrib_row">
														<div class="row col-9 offset-1">
															<div class="col-1 text-danger attrib_delete" data-sectionid="{!! $sect->id !!}" data-itemid="{!! $it->id !!}" data-id="{!! $att1->id !!}">
																<i class="fas fa-trash" aria-hidden="true"></i>
															</div>
															{!! Form::hidden('qs['.($t1-1).'][qssection]['.($t3-1).'][qsitem]['.$t29++.'][id]', $att1->id) !!}
@if($att1->attribute_id == 10)
	<span class="name1" data-content="<img src='{{ asset('storage/'.$att1->image) }}'' alt='{{ $att1->description_attribute }}' class='img-thumbnail rounded img-fluid' >" data-placement="bottom" data-original-title="{{ $att1->description_attribute }}" >
		{{ !is_null($att1->description_attribute)?$att1->description_attribute:'Image' }}
	</span>
@endif
															<div class="form-group col-2 {{ $errors->has('qs.*.qssection.*.qsitem.*.attribute_id') ? 'has-error' : '' }}">
																<select name="qs[{!! $t1-1 !!}][qssection][{!! $t3-1 !!}][qsitem][{!! $t17++ !!}][attribute_id]" id="attrib_id_{!! $t1-1 !!}_{!! $t3-1 !!}_{!! $t18++ !!}" class="form-control form-control-sm attrib" placeholder="Please choose">
																	'<option value="">Please choose</option>' +
										@foreach(\App\Model\QuotItemAttribute::all() as $attrib)
																	<option value="{!! $attrib->id !!}" {!! ($attrib->id == $att1->attribute_id)?'selected':NULL !!}>{!! $attrib->attribute !!}</option>
										@endforeach
																</select>
															</div>
															<div class="form-group col-2 image {{ $errors->has('qs.*.qssection.*.qsitem.*.description_attribute') ? 'has-error' : '' }}">
																<input type="text" name="qs[{!! $t1-1 !!}][qssection][{!! $t3-1 !!}][qsitem][{!! $t19++ !!}][description_attribute]" value="{!! $att1->description_attribute !!}" id="description_attribute_{!! $t1-1 !!}_{!! $t3-1 !!}_{!! $t20++ !!}" class="form-control form-control-sm inputattrib" placeholder="Description">
															</div>
															<div class="form-group col-2 {{ $errors->has('qs.*.qssection.*.qsitem.*.image') ? 'has-error' : '' }}">
																<input type="file" name="qs[{!! $t1-1 !!}][qssection][{!! $t3-1 !!}][qsitem][{!! $t21++ !!}][image]" value="{!! $att1->image !!}" id="image_{!! $t1-1 !!}_{!! $t3-1 !!}_{!! $t22++ !!}" class="form-control form-control-file form-control-sm" placeholder="Image">
															</div>
															<div class="form-group col-3 {{ $errors->has('qs.*.qssection.*.qsitem.*.remarks') ? 'has-error' : '' }}">
																<input type="text" name="qs[{!! $t1-1 !!}][qssection][{!! $t3-1 !!}][qsitem][{!! $t23++ !!}][remarks]" value="{!! $att1->remarks !!}" id="remarks_{!! $t1-1 !!}_{!! $t3-1 !!}_{!! $t24++ !!}" class="form-control form-control-sm" placeholder="Remarks">
															</div>
														</div>
													</div>


					@endforeach
				@else
				@endif


												</div>
<!-- end wrapper for attribute -->


												<div class="row col-2 attrib_add"  data-sectionid="{!! $t1-1 !!}" data-itemid="{!! $t3-1 !!}">
													<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Item Attribute</p>
												</div>
											</div>

			@endforeach
		@else
		@endif
		<?php $gtotal += $price ?>
										</div>
<!-- end wrapper for item -->


									</div>
								</div>
								<div class="row col-2 item_add" data-sectionid="{{ $t1-1 }}">
									<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Item</p>
								</div>
							</div>
						</div>
						<div class="form-row row col-12">
							<div class="form-group col-3 offset-8">
								<label for="grandtotal" class="col col-form-label">Total :</label>
							</div>
							<div class="form-group col-1">
								<input type="text" value="{!! ($price>0)?$price:'0.00' !!}" class="form-control form-control-sm totalprice" disabled="disabled">
							</div>
						</div>
					</div>
				</div>
			</div>
			<br />
@endforeach
@else
@endif

</div>
<!-- end wrapper for section -->

<?php
$ap = (($quot->tax_value * $gtotal) / 100) + $gtotal;
?>

<div class="row col-2 section_add">
	<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Section</p>
</div>

<!-- GST -->
<div class="form-row row col-12">
	<div class="form-group col-2 offset-8">
		<label for="tax_id" class="col col-form-label">GST TAX :</label>
	</div>
	<div class="form-group col-1 {{ $errors->has('tax_id') ? 'has-error' : '' }}">
		<select name="tax_id" id="tax_id" class="form-control form-control-sm gst" placeholder="Please choose" >
			<option value="">Please choose</option>
@foreach(\App\Model\Tax::all() as $tax)
			<option value="{!! $tax->id !!}" data-taxvalue="{!! $tax->value !!}" {!! ($tax->id == $quot->tax_id)?'selected':NULL !!}>{!! $tax->tax !!}</option>
@endforeach
		</select>
	</div>
	<div class="form-group col-1 {{ $errors->has('tax_value') ? 'has-error' : '' }}">
		{!! Form::text('tax_value', @$value, ['class' => 'form-control form-control-sm gstvalue', 'id' => 'tax_value', 'placeholder' => 'GST Value (%)']) !!}
	</div>
</div>

<!-- grand total -->
<div class="form-row row col-12">
	<div class="col-3 offset-8">
		<label for="grandtotal" class="col col-form-label">Grand Total :</label>
	</div>
	<div class="form-group col-1">
		<input type="text" value="{!! ($ap>0)?$ap:'0.00' !!}" class="form-control form-control-sm grandtotal" id="grandtotal" disabled="disabled">
	</div>
</div>


<div class="row">
	{{ Form::label( 'ddp', 'Delivery Date : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class="form-row col-10">
		<div class="form-group col-2 {{ $errors->has('from')?'has-error':NULL }}">{!! Form::text('from', @$value, ['class' => 'form-control form-control-sm', 'id' => 'ddf', 'placeholder' => 'From']) !!}</div> to 
		<div class="form-group col-2 {{ $errors->has('to')?'has-error':NULL }}">{!! Form::text('to', @$value, ['class' => 'form-control form-control-sm', 'id' => 'ddf', 'placeholder' => 'To']) !!}</div>
		<div class="form-group col-2 {{ $errors->has('period_id')?'has-error':NULL }}">{!! Form::select('period_id', \App\Model\QuotDeliveryDate::pluck('delivery_date_period', 'id')->toArray(), @$value, ['class' => 'form-control form-control-sm', 'id' => 'ddp', 'placeholder' => 'Please choose']) !!}</div>  upon confirmation of order and receipt of down payment. 
	</div>
</div>

<div class="row">
	{{ Form::label( 'valid', 'Validity : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class="form-row col-10">
		<div class="form-group col-2 {{ $errors->has('validity')?'has-error':NULL }}">{!! Form::text('validity', @$value, ['class' => 'form-control form-control-sm', 'id' => 'valid', 'placeholder' => 'Validity']) !!}</div> days from quotation date.
	</div>
</div>

<!-- term of payment -->
<div class="row">
	{{ Form::label( 'top', 'Term Of Payment : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class=" col-10">

		<div class="top_wrapper">
@if( $quot->hasmanytermofpayment()->get()->count() )
<?php
$r1 = 1;
$r2 = 1;
$r3 = 1;
$r4 = 1;
?>
@foreach($quot->hasmanytermofpayment()->get() as $top)
			<div class="row top_row">
				<div class="col-1 text-danger top_delete" data-id="{!! $top->id !!}">
					<i class="fas fa-trash" aria-hidden="true"></i>
				</div>
				{!! Form::hidden('qstop['.$r1++.'][id]', $top->id) !!}
				{!! Form::hidden('qstop['.$r2++.'][quot_id]', $top->quot_id) !!}
				<div class="form-group col {{ $errors->has('qstop.*.term_of_payment') ? 'has-error' : '' }}">
					<input type="text" name="qstop[{!! $r3++ !!}][term_of_payment]" value="{!! $top->term_of_payment !!}" id="top_{!! $r4++ !!}" class="form-control form-control-sm" placeholder="Term Of Payment">
				</div>
			</div>
@endforeach
@endif
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
@if($quot->hasmanyexclusions()->get()->count())
<?php
$e1 = 1;
$e2 = 1;
$e3 = 1;
$e4 = 1;
?>
@foreach($quot->hasmanyexclusions()->get() as $ty)
			<div class="row exc_row">
				<div class="col-1 text-danger exc_delete" data-id="{!! $ty->id !!}">
					<i class="fas fa-trash" aria-hidden="true"></i>
				</div>

				{!! Form::hidden('qsexclusions['.$e1++.'][id]', $ty->id) !!}
				{!! Form::hidden('qsexclusions['.$e2++.'][quot_id]', $ty->quot_id) !!}

				<div class="form-group col {{ $errors->has('qsexclusions.*.exclusion_id') ? 'has-error' : '' }}">
					<select name="qsexclusions[{!! $e3++ !!}][exclusion_id]" class="form-control form-control-sm" id="exclusion_{!! $e4++ !!}" placeholder="Please choose">
						<option value="">Please choose</option>
					@foreach(\App\Model\QuotExclusion::all() as $exc)
						<option value="{!! $exc->id !!}" {!! ($ty->exclusion_id == $exc->id)?'selected':NULL !!}>{!! $exc->exclusion !!}</option>
					@endforeach
					</select>
				</div>
			</div>
@endforeach
@endif
		</div>
		<div class="row col-3 exc_add">
			<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Exclusions</p>
		</div>

	</div>
</div>

<!-- remarks -->
<div class="row">
	{{ Form::label( 'exclude', 'Remarks : ', ['class' => 'col-2 col-form-label'] ) }}
	<div class=" col-10">

		<div class="rem_wrapper">
@if( $quot->hasmanyremarks()->get()->count() )
<?php
$e5 = 1;
$e6 = 1;
$e7 = 1;
$e8 = 1;
?>
@foreach( $quot->hasmanyremarks()->get() as $hy )
			<div class="row rem_row">
				<div class="col-1 text-danger rem_delete" data-id="{!! $hy->id !!}">
					<i class="fas fa-trash" aria-hidden="true"></i>
				</div>

				{!! Form::hidden('qsremark['.$e5++.'][id]', $hy->id) !!}
				{!! Form::hidden('qsremark['.$e6++.'][quot_id]', $hy->quot_id) !!}

				<div class="form-group col {{ $errors->has('qsremark.*.exclusion_id') ? 'has-error' : '' }}">
					<select name="qsremark[{!! $e7++ !!}][remark_id]" class="form-control form-control-sm" id="remark_{!! $e8++ !!}" placeholder="Please choose">
						<option value="">Please choose</option>
					@foreach(\App\Model\QuotRemark::all() as $rem)
						<option value="{!! $rem->id !!}" {!! ($rem->id == $hy->remark_id)?'selected':NULL !!}>{!! $rem->quot_remarks !!}</option>
					@endforeach
					</select>
				</div>
			</div>
@endforeach
@endif
		</div>
		<div class="row col-3 rem_add">
			<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Remarks</p>
		</div>

	</div>
</div>








<div class="form-group row">
	{!! Form::label('gamount', 'Grand Amount : ', ['class' => 'col-form-label col-2']) !!}
	<div class="col-10">
		{!! Form::text('grandamount', @$value, ['class' => 'form-control form-control-sm', 'id' => 'gamount', 'placeholder' => 'Grand Amount In English']) !!}
	</div>
</div>

<p>&nbsp;</p>

<div class="form-group row">
	<div class="col-10 offset-2">
		{!! Form::button('Update', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
	</div>
</div>