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
//ucwords
$('#dat').datetimepicker({
	format:'YYYY-MM-DD',
	useCurrent: true,
})
.on('dp.change dp.show dp.update', function() {
	$('#form').bootstrapValidator('revalidateField', 'date');
});

/////////////////////////////////////////////////////////////////////////////////////////
// select2
$('#curr, #cust, #tax_id').select2({
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
	//user click on remove section
	e.preventDefault();
	var $row = $(this).parent().parent().parent().parent();
	var $option1 = $row.find('[name="qs[' + section_id + '][section]"]');
	$row.remove();
	// $row.css('border', 'solid 1px red');

	$('#form').bootstrapValidator('removeField', $option1);
	console.log(xs);
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
						'<input type="text" name="qs[' + section_id + '][qssection][' + xi + '][quantity]" value="" id="quantity_' + section_id + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Quantity" />' +
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
						'<input type="text" name="qs[' + section_id + '][qssection][' + xi + '][tax_value]" value="" id="tax_value_' + section_id + '_' + xi + '" class="form-control form-control-sm taxvalue" autocomplete="off" placeholder="Tax Value" />' +
					'</div>' +
					'<div class="form-group col">' +
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
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][item_id]"]'));
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][price_unit]"]'));
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][description]"]'));
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][tax_id]"]'));
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][tax_value]"]'));
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][quantity]"]'));
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][uom_id]"]'));
	}

});

$(document).on('click', '.item_remove', function(e) {
// $(".item_remove").click(function(e){
	var section_id = $(this).data('sectionid');
	var item_id = $(this).data('itemid');
	//user click on remove item
	e.preventDefault();
	var $row = $(this).parent().parent();
	var $option1 = $row.find('[name="qs[' + section_id + '][qssection][' + item_id + '][item_id]"]');
	$row.remove();
	// console.log('sectionid = ' + section_id + ' | itemid = ' + item_id);
	// $row.css('border', 'solid 1px red');

	// $('#form').bootstrapValidator('removeField', $option1);
	// console.log(xi);
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
						'<select name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][attribute_id]" id="attrib_id_' + section_id + '_' + item_id + '_' + xia + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotItemAttribute::all() as $attrib)
							'<option value="{!! $attrib->id !!}" >{!! $attrib->attribute !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col-2 {{ $errors->has('qs.*.qssection.*.qsitem.*.description_attribute') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][description_attribute]" id="description_attribute_' + section_id + '_' + item_id + '_' + xia + '" class="form-control form-control-sm" placeholder="Description">' +
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
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][attribute_id]"]'));
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][description_attribute]"]'));
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][remarks]"]'));
	}

});

$(document).on('click', '.attrib_remove', function(e) {
	var section_id = $(this).data('sectionid');
	var item_id = $(this).data('itemid');
	var attrib_id = $(this).data('itemid');

	//user click on remove item
	e.preventDefault();
	var $row = $(this).parent().parent();
	var $option1 = $row.find('[name="qs[' + section_id + '][qssection][' + item_id + '][item_id]"]');
	$row.remove();
	// console.log('sectionid = ' + section_id + ' | itemid = ' + item_id);
	// $row.css('border', 'solid 1px red');

	// $('#form').bootstrapValidator('removeField', $option1);
	// console.log(xia);
	xia--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// auto populate price/unit and change the price and the total price
$(document).on('change', '.itemprice', function () {
	selectedOption = $('option:selected', this);
	var retail = $(this).parent().parent().children().children('.priceunit');

	$(retail).val( selectedOption.data('price') );
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// auto populate tax and change the tax value
$(document).on('change', '.tax', function () {
	selectedOption = $('option:selected', this);
	var tvalue = $(this).parent().parent().children().children('.taxvalue');

	$(tvalue).val( selectedOption.data('taxvalue') + '%' );
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// auto populate tax and change the tax value
$(document).on('change', '.tax', function () {
	selectedOption = $('option:selected', this);
	var tvalue = $(this).parent().parent().children().children('.taxvalue');

	$(tvalue).val( selectedOption.data('taxvalue') + '%' );
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// auto populate tax and change the tax value
$(document).on('change', '.gst', function () {
	selectedOption = $('option:selected', this);
	var gstval = $(this).parent().parent().children().children('.gstvalue');

	$(gstval).val( selectedOption.data('taxvalue') + '%' );
});

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

@for($i = 1; $i <= 50; $i++)
		'qs[{!! $i !!}][section]': {
			validators: {
				notEmpty: {
					message: 'Please insert Section Title. ',
				}
			}
		},
@endfor

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

