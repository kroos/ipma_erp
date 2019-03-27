@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Costing Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(3)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 7)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('quot.index') }}">Quotation</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('ics.costing') }}">Intelligence Customer Service</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">
				Add Quotation
			</div>
			<div class="card-body">
{!! Form::open(['route' => ['quot.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
@include('marketingAndBusinessDevelopment.costing.quotation._create')
{!! Form::close() !!}
			</div>
		</div>

	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// date
$('#dat').datetimepicker({
	format:'YYYY-MM-DD',
	useCurrent: true,
})
.on('dp.change dp.show dp.update', function() {
	$('#form').bootstrapValidator('revalidateField', 'date');
});

/////////////////////////////////////////////////////////////////////////////////////////
// select2
$('#curr, #cust, #tax_id, #ddp, #exclusion_1, #remark_1').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
// add section : add and remove row

var max_fields	= 50; //maximum input boxes allowed
var add_buttons	= $(".section_add");
var wrappers	= $(".section_wrapper");

var xs = 0;
$(add_buttons).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xs < max_fields){
		xs++;
		wrappers.append(

			'<div class="section_row">' +
				'<div class="card">' +
					'<div class="card-header">Section</div>' +
					'<div class="card-body">' +
						'<div class="row">' +
							'<div class="col-1 text-danger section_remove"  id="section_remove_' + xs + '" data-sectionid="' + xs + '">' +
								'<i class="fas fa-trash" aria-hidden="true"></i>' +
							'</div>' +
							'<div class="form-group col-11 {{ $errors->has('qs.*.section') ? 'has-error' : '' }}">' +
								'<input type="text" name="qs[' + xs + '][section]" value="" id="section_' + xs + '" class="form-control form-control-sm" autocomplete="off" placeholder="Section Title" />' +
							'</div>' +
							'<div class="col-12">' +
								'<div class="card">' +
									'<div class="card-header">Item</div>' +
									'<div class="card-body">' +
										'<div class="col item_wrap">' +

										'</div>' +
									'</div>' +
								'</div>' +
								'<div class="row col-2 item_add" data-sectionid="' + xs + '">' +
									'<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Item</p>' +
								'</div>' +
							'</div>' +
						'</div>' +

						'<div class="form-row row col-12">' +
							'<div class="form-group col-3 offset-8">' +
								'<label for="grandtotal" class="col col-form-label">Total :</label>' +
							'</div>' +
							'<div class="form-group col-1">' +
								'<input type="text" value="0.00" class="form-control form-control-sm totalprice" disabled="disabled">' +
							'</div>' +
						'</div>' +

					'</div>' +
				'</div>' +
			'</div>' +
			'<br />'

		);		// add input box


		//bootstrap validate
		$('#form').bootstrapValidator('addField', $('.section_row').find('[name="qs[' + xs + '][section]"]'));
	}
});

$(wrappers).on("click",".section_remove", function(e){
	var section_id = $(this).data('sectionid');
	e.preventDefault();
	var $row1 = $(this).parent().parent().parent().parent();
	var $option1 = $row1.find('[name="qs[' + section_id + '][section]"]');
	$('#form').bootstrapValidator('removeField', $option1);
	$row1.remove();
	// $option1.css('border', 'solid 1px red');

	xs--;
})

/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on item
var max_items	= max_fields * 50;		//maximum input boxes allowed
var xi = 0;

$(document).on('click', '.item_add', function() {
// $('.item_add').click(function(e){
	var item_wrapper = $(this).parent().children().children().children('.item_wrap');
	// item_wrapper.css('border', 'solid 1px red');
	var section_id = $(this).data('sectionid');

	if(xi < max_items){
		xi++;
		$(item_wrapper).append(

			'<div class="item_row">' +
				'<div class="form-row col-12">' +
					'<div class="col-1 text-danger item_remove" data-sectionid="' + section_id + '" data-itemid="' + xi + '">' +
							'<i class="fas fa-trash" aria-hidden="true"></i>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.item_id') ? 'has-error' : '' }}">' +
						'<select name="qs[' + section_id + '][qssection][' + xi + '][item_id]" id="item_' + section_id + '_' + xi + '" class="form-control form-control-sm itemprice" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotItem::where('active', 1)->get() as $item)
							'<option value="{!! $item->id !!}" data-price="{!! $item->price !!}">{!! $item->item !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.price_unit') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + xi + '][price_unit]" id="price_unit_' + section_id + '_' + xi + '" class="form-control form-control-sm priceunit" placeholder="Price/Unit">' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.description') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + xi + '][description]" id="remarks_' + section_id + '_' + xi + '" class="form-control form-control-sm" placeholder="Remarks" />' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.quantity') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + xi + '][quantity]" value="" id="quantity_' + section_id + '_' + xi + '" class="form-control form-control-sm quan" autocomplete="off" placeholder="Quantity" />' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.uom_id') ? 'has-error' : '' }}">' +
						'<select name="qs[' + section_id + '][qssection][' + xi + '][uom_id]" id="uom_id_' + section_id + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotUOM::all() as $uom)
							'<option value="{!! $uom->id !!}" >{!! $uom->uom !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.tax_id') ? 'has-error' : '' }}">' +
						'<select type="text" name="qs[' + section_id + '][qssection][' + xi + '][tax_id]" value="" id="tax_id_' + section_id + '_' + xi + '" class="form-control form-control-sm tax" autocomplete="off" placeholder="Please choose" >' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\Tax::all() as $tax)
							'<option value="{!! $tax->id !!}" data-taxvalue="{!! $tax->value !!}">{!! $tax->tax !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.tax_value') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + xi + '][tax_value]" value="" id="tax_value_' + section_id + '_' + xi + '" class="form-control form-control-sm taxvalue" autocomplete="off" placeholder="Tax Value (%)" />' +
					'</div>' +
					'<div class="form col">' +
						'<input type="text" value="0.00" class="form-control form-control-sm price" disabled="disabled">' +
					'</div>' +
				'</div>' +
				'<div class="col attrib_wrap">' +

				'</div>' +
				'<div class="row col-2 attrib_add"  data-sectionid="' + section_id + '" data-itemid="' + xi + '">' +
					'<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Item Attribute</p>' +
				'</div>' +
			'</div>'

		);		// add input box

		// select 2
		$( '#item_' + section_id + '_' + xi + ', #tax_id_' + section_id + '_' + xi + ', #uom_id_' + section_id + '_' + xi ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][item_id]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][price_unit]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][description]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][tax_id]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][tax_value]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][quantity]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][uom_id]"]'));
	}

});

$(document).on('click', '.item_remove', function(e) {

	var section_id = $(this).data('sectionid');
	var item_id = $(this).data('itemid');

	e.preventDefault();
	var $row2 = $(this).parent().parent();

	var $option2 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][item_id] "]');
	var $option3 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][price_unit]"]');
	var $option4 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][description]"]');
	var $option5 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][tax_id]"]');
	var $option6 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][tax_value]"]');
	var $option7 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][quantity]"]');
	var $option8 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][uom_id]"]');


	$('#form').bootstrapValidator('removeField', $option2);
	$('#form').bootstrapValidator('removeField', $option3);
	$('#form').bootstrapValidator('removeField', $option4);
	$('#form').bootstrapValidator('removeField', $option5);
	$('#form').bootstrapValidator('removeField', $option6);
	$('#form').bootstrapValidator('removeField', $option7);
	$('#form').bootstrapValidator('removeField', $option8);

	$row2.remove();
	// $option3.css('border', 'solid 2px red');

	xi--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on item attrib
var max_items_attrib	= max_items * 50;		//maximum input boxes allowed
var xia = 0;

$(document).on('click', '.attrib_add', function() {
	var item_attrib_wrapper = $(this).parent().children('.attrib_wrap');
	// item_attrib_wrapper.css('border', 'solid 1px red');
	var section_id = $(this).data('sectionid');
	var item_id = $(this).data('itemid');

	if(xia < max_items_attrib){
		xia++;
		$(item_attrib_wrapper).append(

			'<div class="attrib_row">' +
				'<div class="row col-9 offset-1">' +
					'<div class="col-1 text-danger attrib_remove" data-sectionid="' + section_id + '" data-itemid="' + item_id + '" data-id="' + xia + '">' +
						'<i class="fas fa-trash" aria-hidden="true"></i>' +
					'</div>' +
					'<div class="form-group col-2 {{ $errors->has('qs.*.qssection.*.qsitem.*.attribute_id') ? 'has-error' : '' }}">' +
						'<select name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][attribute_id]" id="attrib_id_' + section_id + '_' + item_id + '_' + xia + '" class="form-control form-control-sm attrib" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotItemAttribute::all() as $attrib)
							'<option value="{!! $attrib->id !!}" >{!! $attrib->attribute !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col-2 image {{ $errors->has('qs.*.qssection.*.qsitem.*.description_attribute') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][description_attribute]" id="description_attribute_' + section_id + '_' + item_id + '_' + xia + '" class="form-control form-control-sm inputattrib" placeholder="Description">' +
					'</div>' +
					'<div class="form-group col-2 {{ $errors->has('qs.*.qssection.*.qsitem.*.image') ? 'has-error' : '' }}">' +
						'<input type="file" name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][image]" id="image_' + section_id + '_' + item_id + '_' + xia + '" class="form-control form-control-file form-control-sm" placeholder="Image">' +
					'</div>' +
					'<div class="form-group col-3 {{ $errors->has('qs.*.qssection.*.qsitem.*.remarks') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][remarks]" id="remarks_' + section_id + '_' + item_id + '_' + xia + '" class="form-control form-control-sm" placeholder="Remarks">' +
					'</div>' +
				'</div>' +
			'</div>'
		);		// add input box

		// select 2
		$( '#attrib_id_' + section_id + '_' + item_id + '_' + xia ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.attrib_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][attribute_id]"]'));
		$('#form').bootstrapValidator('addField',$('.attrib_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][description_attribute]"]'));
		$('#form').bootstrapValidator('addField',$('.attrib_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][remarks]"]'));
	}

});

$(document).on('click', '.attrib_remove', function(e) {
	var section_id = $(this).data('sectionid');
	var item_id = $(this).data('itemid');
	var attrib_id = $(this).data('itemid');

	e.preventDefault();
	var $row3 = $(this).parent().parent();

	var $option9 = $row3.find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + attrib_id + '][attribute_id]"]');
	var $option10 = $row3.find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + attrib_id + '][description_attribute]"]');
	var $option11 = $row3.find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + attrib_id + '][remarks]"]');

	$('#form').bootstrapValidator('removeField', $option9);
	$('#form').bootstrapValidator('removeField', $option10);
	$('#form').bootstrapValidator('removeField', $option11);

	$row3.remove();

	// $option10.css('border', 'solid 1px red');

	xia--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on term of payment
var top	= 10;		//maximum input boxes allowed
var xt = 1;

$(document).on('click', '.top_add', function() {
	var top_wrapper = $(this).parent().children('.top_wrapper');
	// top_wrapper.css('border', 'solid 1px red');

	if(xt < top){
		xt++;
		$(top_wrapper).append(

			'<div class="row top_row">' +
				'<div class="col-1 text-danger top_remove" data-id="' + xt + '">' +
					'<i class="fas fa-trash" aria-hidden="true"></i>' +
				'</div>' +
				'<div class="form-group col {{ $errors->has('qstop.*.term_of_payment') ? 'has-error' : '' }}">' +
					'<input type="text" name="qstop[' + xt + '][term_of_payment]" id="top_' + xt + '" class="form-control form-control-sm" placeholder="Term Of Payment">' +
				'</div>' +
			'</div>'

		);		// add input box

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.top_row').find('[name="qstop[' + xt + '][term_of_payment]"]'));
	}

});

$(document).on('click', '.top_remove', function(e) {
	var top_id = $(this).data('id');

	e.preventDefault();
	var $row4 = $(this).parent('.top_row');
	// $row4.css('border', 'solid 1px red');

	var $option12 = $row4.find('[name="qstop[' + top_id + '][term_of_payment]"]');

	$('#form').bootstrapValidator('removeField', $option12);

	$row4.remove();

	// $option12.css('border', 'solid 1px red');

	xt--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on exclusions
var max_exc	= 20;		//maximum input boxes allowed
var xexc = 1;

$(document).on('click', '.exc_add', function() {
	var exc_wrapper = $(this).parent().children('.exc_wrapper');
	// exc_wrapper.css('border', 'solid 1px red');

	if(xexc < max_exc){
		xexc++;
		$(exc_wrapper).append(

			'<div class="row exc_row">' +
				'<div class="col-1 text-danger exc_remove" data-id="' + xexc + '">' +
					'<i class="fas fa-trash" aria-hidden="true"></i>' +
				'</div>' +
				'<div class="form-group col {{ $errors->has('qsexclusions.*.exclusion_id') ? 'has-error' : '' }}">' +
					'<select name="qsexclusions[' + xexc + '][exclusion_id]" class="form-control form-control-sm" id="exclusion_' + xexc + '" placeholder="Please choose">' +
						'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotExclusion::all() as $exc)
						'<option value="{!! $exc->id !!}">{!! $exc->exclusion !!}</option>' +
@endforeach
					'</select>' +
				'</div>' +
			'</div>'

		);		// add input box

		// select2
		$( '#exclusion_' + xexc ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.exc_row').find('[name="qsexclusions[' + xexc + '][exclusion_id]"]'));
	}

});

$(document).on('click', '.exc_remove', function(e) {
	var exc_id = $(this).data('id');

	e.preventDefault();
	var $row5 = $(this).parent('.exc_row');
	// $row5.css('border', 'solid 1px red');

	var $option13 = $row5.find('[name="qsexclusions[' + exc_id + '][exclusion_id]"]');

	$('#form').bootstrapValidator('removeField', $option13);
	$row5.remove();

	// $option13.css('border', 'solid 1px red');

	xexc--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on remark
var max_rem	= 20;		//maximum input boxes allowed
var xrem = 1;

$(document).on('click', '.rem_add', function() {
	var rem_wrapper = $(this).parent().children('.rem_wrapper');
	// rem_wrapper.css('border', 'solid 1px red');

	if(xrem < max_rem){
		xrem++;
		$(rem_wrapper).append(

			'<div class="row rem_row">' +
				'<div class="col-1 text-danger rem_remove" data-id="' + xrem + '">' +
					'<i class="fas fa-trash" aria-hidden="true"></i>' +
				'</div>' +
				'<div class="form-group col {{ $errors->has('qsremark.*.remark_id') ? 'has-error' : '' }}">' +
					'<select name="qsremark[' + xrem + '][remark_id]" class="form-control form-control-sm" id="remark_' + xrem + '" placeholder="Please choose">' +
						'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotRemark::all() as $rem)
						'<option value="{!! $rem->id !!}">{!! $rem->quot_remarks !!}</option>' +
@endforeach
					'</select>' +
				'</div>' +
			'</div>'

		);		// add input box

		// select2
		$( '#remark_' + xrem ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.rem_row').find('[name="qsremark[' + xrem + '][remark_id]"]'));
	}

});

$(document).on('click', '.rem_remove', function(e) {
	var rem_id = $(this).data('id');

	e.preventDefault();
	var $row6 = $(this).parent('.rem_row');
	// $row6.css('border', 'solid 1px red');

	var $option14 = $row6.find('[name="qsremark[' + rem_id + '][remark_id]"]');

	$('#form').bootstrapValidator('removeField', $option14);
	$row6.remove();

	// $option14.css('border', 'solid 1px red');

	xrem--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// auto populate price/unit and change the price and the total price
$(document).on('change', '.itemprice', function () {
	selectedOption = $('option:selected', this);
	var retail = $(this).parent().parent().children().children('.priceunit');

	$(retail).val( selectedOption.data('price') );

	// calculate for total price of a section and grand total
	var quan = $(this).parent().parent().children().children('.quan');
	var price = $(this).parent().parent().children().children('.price');

	$(price).val( ( ( ($(quan).val() * 10) * ($(retail).val() * 10) )/100 ).toFixed(2) );

	// directly update totalprice
	var pri = $(this).parent().parent().parent().parent().parent().find('.price');
	var tp = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children().children().children().children('.totalprice');

	// $(pri).css('border', 'solid 1px red');

	var myNodelistp1 = $(pri);
	var psum1 = 0;
	for (var ip1 = myNodelistp1.length - 1; ip1 >= 0; ip1--) {
		// myNodelistp1[ip1].style.backgroundColor = "red";

		psum1 = ((psum1 * 10000) + (myNodelistp1[ip1].value * 10000)) / 10000;
	}

	$(tp ).val( psum1.toFixed(2) );

	// update grand total
	update_grandtotal();
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// auto populate tax and change the tax value
$(document).on('change', '.tax', function () {
	selectedOption = $('option:selected', this);
	var tvalue = $(this).parent().parent().children().children('.taxvalue');

	$(tvalue).val( selectedOption.data('taxvalue') );
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// auto populate tax and change the tax value
$(document).on('change', '.gst', function () {
	selectedOption = $('option:selected', this);
	var gstval = $(this).parent().parent().children().children('.gstvalue');

	$(gstval).val( selectedOption.data('taxvalue') );

	// calculate the tax
	// update grand total
	update_grandtotal();
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// javascript calculation

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// calculating every row for a price
$(document).on('keyup', '.quan', function () {
	var unitprice = $(this).parent().parent().children().children('.priceunit');
	var price = $(this).parent().parent().children().children('.price');

	$(price).val( ( ( ($(this).val() * 10) * ($(unitprice).val() * 10) ) / 100).toFixed(2) );

	// directly update totalprice
	var pri = $(this).parent().parent().parent().parent().parent().find('.price');
	var tp = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children().children().children().children('.totalprice');

	// $(pri).css('border', 'solid 1px red');

	var myNodelistp1 = $(pri);
	var psum1 = 0;
	for (var ip1 = myNodelistp1.length - 1; ip1 >= 0; ip1--) {
		// myNodelistp1[ip1].style.backgroundColor = "red";

		psum1 = ((psum1 * 10000) + (myNodelistp1[ip1].value * 10000)) / 10000;
	}

	$(tp ).val( psum1.toFixed(2) );

	// update grand total
	update_grandtotal();
});

$(document).on('keyup', '.priceunit', function () {
	var quan = $(this).parent().parent().children().children('.quan');
	var price = $(this).parent().parent().children().children('.price');

	$(price).val( ( ( ($(this).val() * 10) * ($(quan).val() * 10) ) / 100).toFixed(2) );

	// directly update totalprice
	var pri = $(this).parent().parent().parent().parent().parent().find('.price');
	var tp = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children().children().children().children('.totalprice');

	// $(pri).css('border', 'solid 1px red');

	var myNodelistp1 = $(pri);
	var psum1 = 0;
	for (var ip1 = myNodelistp1.length - 1; ip1 >= 0; ip1--) {
		// myNodelistp1[ip1].style.backgroundColor = "red";

		psum1 = ((psum1 * 10000) + (myNodelistp1[ip1].value * 10000)) / 10000;
	}

	$(tp ).val( psum1.toFixed(2) );

	// update grand total
	update_grandtotal();
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// update tax
$(document).on('keyup', '#tax_value', function() {
	// update grand total
	update_grandtotal();
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// total price for each section
function update_grandtotal() {
	var myNodelistp = $(".totalprice");
	var psum = 0;
	for (var ip = myNodelistp.length - 1; ip >= 0; ip--) {
		// myNodelistp[ip].style.backgroundColor = "red";

		psum = ((psum * 10000) + (myNodelistp[ip].value * 10000)) / 10000;
	}

	var gstval = $('#tax_value').val();
	var ttg = ((gstval / 100) * psum) + psum;

	// $('#grandtotal' ).val( psum.toFixed(2) );
	$('#grandtotal' ).val( ttg.toFixed(2) );
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
// form validation
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		'date': {
			validators : {
				notEmpty: {
					message: 'Please insert date. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'The value is not a valid date. '
				},
			}
		},
		currency_id: {
			validators: {
				notEmpty: {
					message : 'Please choose. '
				}
			}
		},
		customer_id: {
			validators: {
				notEmpty: {
					message : 'Please choose. '
				}
			}
		},
		attn: {
			validators: {
				notEmpty: {
					message : 'Please insert Attention To. '
				}
			}
		},
		subject: {
			validators: {
				notEmpty: {
					message : 'Please insert Quotation Subject. '
				}
			}
		},
		description: {
			validators: {
				// notEmpty: {
				// 	message : 'Please insert Remarks. '
				// }
			}
		},
		tax_id: {
			validators: {
				// notEmpty: {
				// 	message: 'Please choose. '
				// },
			}
		},
		tax_value: {
			validators: {
				// notEmpty: {
				// 	message: 'Please choose. '
				// },
				numeric: {
					separator: '.',
					message: 'The value is not in decimal. ',
				},
			}
		},
// section
@for($i1 = 1; $i1 <= 10; $i1++)
		'qs[{!! $i1 !!}][section]': {
			validators: {
				// notEmpty: {
				// 	message: 'Please insert Section Title. ',
				// },
			}
		},
	// item
	@for($i2 =1; $i2 <= 30; $i2++)
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][item_id]' : {
				validators: {
					notEmpty: {
						message: 'Please insert value. ',
					},
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][price_unit]' : {
				validators: {
					notEmpty: {
						message: 'Please insert value. ',
					},
					numeric: {
						separator: '.',
						message: 'The value is not in decimal. ',
					},
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][description]' : {
				validators: {
					// notEmpty: {
					// 	message: 'Please insert value. ',
					// },
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][tax_id]' : {
				validators: {
					// notEmpty: {
					// 	message: 'Please insert value. ',
					// },
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][tax_value]' : {
				validators: {
					// notEmpty: {
					// 	message: 'Please insert value. ',
					// },
					numeric: {
						separator: '.',
						message: 'The value is not in decimal. ',
					},
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][quantity]' : {
				validators: {
					notEmpty: {
						message: 'Please insert value. ',
					},
					integer: {
						message: 'The value is not in integer. '
					}
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][uom_id]' : {
				validators: {
					notEmpty: {
						message: 'Please choose. ',
					},
				}
			},
		// attribute
		@for($i3 =1; $i3 <= 10; $i3++)
				'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][qsitem][{!! $i3 !!}][attribute_id]': {
					validators: {
						notEmpty: {
							message: 'Please choose. ',
						},
					}
				},
				'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][qsitem][{!! $i3 !!}][description_attribute]': {
					validators: {
						// notEmpty: {
						// 	message: 'Please insert value. ',
						// },
					}
				},
				'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][qsitem][{!! $i3 !!}][image]': {
					validators: {
						// notEmpty: {
						// 	message: 'Please insert value. ',
						// },
						file: {
							extension: 'jpeg,jpg,png,bmp',
							type: 'image/jpeg,image/png,image/bmp',
							maxSize: 7990272,   // 3264 * 2448
							message: 'The selected file is not valid'
						},
					}
				},
				'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][qsitem][{!! $i3 !!}][remarks]': {
					validators: {
						// notEmpty: {
						// 	message: 'Please insert value. ',
						// },
					}
				},
		@endfor
	@endfor
@endfor

		from: {
			validators: {
				notEmpty: {
					message: 'Please insert value. '
				},
				digits: {
					message: 'Invalid value, it must be a digit. '
				},
			}
		},
		to: {
			validators: {
				notEmpty: {
					message: 'Please insert value. '
				},
				digits: {
					message: 'Invalid value, it must be a digit. '
				},
			}
		},
		period_id: {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				}
			}
		},
		validity: {
			validators: {
				notEmpty: {
					message: 'Please insert value. '
				},
				digits: {
					message: 'Invalid value, it must be a digit. '
				},
			}
		},
@for($i4=1; $i4<=10; $i4++)
		'qstop[{!! $i4 !!}][term_of_payment]': {
			validators: {
				notEmpty: {
					message: 'Please insert Terms Of Payment. '
				},
			}
		},
@endfor
@for($i5=1; $i5<=20; $i5++)
		'qsexclusions[{!! $i5 !!}][exclusion_id]': {
			validators: {
				notEmpty: {
					message: 'Please choose ',
				},
			}
		},
@endfor
@for($i6=1; $i6<=20; $i6++)
		'qsremark[{!! $i6 !!}][remark_id]': {
			validators: {
				notEmpty: {
					message: 'Please choose ',
				},
			}
		},
@endfor
		grandamount: {
			validators: {
				notEmpty: {
					message: 'Please insert Grand Amount. '
				}
			}
		},
	}
})
.find('[name="reason"]')
// .ckeditor()
// .editor
	.on('change', function() {
		// Revalidate the bio field
	$('#form').bootstrapValidator('revalidateField', 'reason');
	// console.log($('#reason').val());
});
/////////////////////////////////////////////////////////////////////////////////////////
@endsection

